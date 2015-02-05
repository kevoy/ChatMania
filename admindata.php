<?php
include 'startdb.php';
session_start();
if(!isset($_SESSION['admin'])){
	header("Location: adminlogin.php");
}else{
	if(isset($_REQUEST['getLargeImgs'])){
		returnLargeImages();
	}else if(isset($_REQUEST['getSmallImgs'])){
		returnSmallImages();
	}else if(isset($_REQUEST['editchatroom'])){
		editChatroom();
	}else if(isset($_REQUEST['createchatroom'])){
		createChatroom();
	}else if(isset($_REQUEST['deletechatroom'])){
		deleteChatroom();
	}else if(isset($_REQUEST['removeuser'])){
		removeUser();
	}else if(isset($_REQUEST['savesettings'])){
		saveSettings();
	}else if(isset($_REQUEST['saveaccount'])){
		saveAccount();
	}else if(isset($_REQUEST['deletemsg'])){
		deleteMessage();
	}else if(isset($_REQUEST['logout'])){
		logout();
	}else if(isset($_REQUEST['loadusers'])){
		loadUsers();
	}else if(isset($_REQUEST['sendmsg'])){
		sendMessage();
	}else if(isset($_REQUEST['largeimgupload'])){
		uploadLargeImg();
	}else if(isset($_REQUEST['smallimgupload'])){
		uploadSmallImg();
	}
}
function uploadLargeImg(){
	if( $_FILES['file']['name'] != "" )
	{
	   move_uploaded_file($_FILES['file']['tmp_name'], "Images/LargeBackgrounds/".$_FILES['file']['name'] ) or 
	           die( "Could not copy file!");
	           header("Location: adminpanel.php");
	}
	else
	{
	    die("No file specified!");
	}
}
function uploadSmallImg(){
	if( $_FILES['file']['name'] != "" )
	{
	   copy( $_FILES['file']['tmp_name'], "Images/SmallBackgrounds/".$_FILES['file']['name']  ) or 
	           die( "Could not copy file!");
	            header("Location: adminpanel.php");
	}
	else
	{
	    die("No file specified!");
	}
}
function sendMessage(){
	$to = $_REQUEST['msgemail'];
	$subject = "REPLY: ". $_REQUEST['msgsubj'];
	$body = $_REQUEST['msgbody'];
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: no-reply';
	//echo $to;
	if(mail($to, $subject, $body, $headers)){
		echo 'SUCCESS';
	}else{
		echo 'Error';
	}
	
}
function loadUsers(){
	$users = startDB("SELECT * FROM users ORDER BY lastDetected DESC LIMIT ". $_REQUEST['count']. ", 10;" );
	$cur_row = "even";
	if(mysql_num_rows($users)<1){
		echo "end";
	}
	while($row=mysql_fetch_array($users)){ 
		if($cur_row == "odd"){
			$cur_row = "even";
		}else{
			$cur_row = "odd";
		}
		
		echo "<tr  class=\"$cur_row\">";
		echo "<td>". $row['Name']."</td>";
		$rooms = startDB("SELECT * FROM chatrooms WHERE id = ". $row['CurrentRoom']. "; ");
		echo "<td>";
		while($uRooms = mysql_fetch_array($rooms)){
			echo $uRooms['Name'];
		}
		echo "</td>";
		echo "<td>" .$row['lastDetected']. "</td>";
		$msgs = startDB("SELECT * FROM chatroom_messages WHERE User = " ."'". $row['Name'] ."'"." ORDER BY Time DESC LIMIT 0, 1;" );
		echo "<td>";
		while($uRow = mysql_fetch_array($msgs)){
			echo htmlspecialchars($uRow['Message']);
		}
		echo "</td>";
		echo "<td><a class=\"table-button\" onclick=\"removeUser('". $row['Name']. "')\">Remove User</a></td>";
		echo "</tr>";
	}
}
function logout(){
	session_destroy();
	header("Location: adminlogin.php");
}
function checkConnectionError($results){
	if(!$results){
		echo "Error ". mysql_error();
	}else{
		echo "SUCCESS";
	}
}
function deleteMessage(){
	$results = startDB("DELETE FROM messages WHERE id = '".$_REQUEST['id']."';");
	checkConnectionError($results);
}
function saveAccount(){
	$results = startDB("UPDATE admin SET Username = '".  $_REQUEST['username'] ."', Email = '". $_REQUEST['email']."', Password = '". $_REQUEST['password']."' WHERE id= 0;");
	checkConnectionError($results);
}
function saveSettings(){
	$t = explode("-s-", $_REQUEST['sitename']);
	$siteTitle1 = $t[0];
	$siteTitle2 = $t[1];
	$sitename = $siteTitle1 ."#" . $siteTitle2;
	$results = startDB("UPDATE settings SET SiteTitle = '". esc($sitename)
		."', SiteDescription = '". esc($_REQUEST['desc'])."', SiteBackground = '". $_REQUEST['back']."', About = '". esc($_REQUEST['abt']) ."', Contact = '". esc($_REQUEST['cnt'])."', AdsCode = '". esc(imap_base64($_REQUEST['adsv'])). "', AdsCodeH = '". esc(imap_base64($_REQUEST['adsh']))."' WHERE id= 0;");
	checkConnectionError($results);
}
function removeUser(){
	$results = startDB("DELETE FROM users WHERE Name = " ."'".esc($_REQUEST['name'])."';");
	$results2 = startDB("DELETE FROM chatroom_messages WHERE User = " ."'".esc($_REQUEST['name'])."';");
	checkConnectionError($results);
}
function deleteChatroom(){
	$results = startDB("DELETE FROM chatrooms WHERE id = " .$_REQUEST['id']);
	checkConnectionError($results);
}
function createChatroom(){
	$results_id = startDB("SELECT * FROM  chatrooms ORDER BY id DESC LIMIT 0, 1");
	$id = 111;
	while($row = mysql_fetch_array($results_id)){
		$id = $row['id'] +1;
	}
	$results = startDB("INSERT INTO chatrooms VALUES ('$id', '". esc($_REQUEST['name']). "', '". esc($_REQUEST['desc']). "', '". $_REQUEST['smallimg']. "', '". $_REQUEST['largeimg']. "');");
	checkConnectionError($results);
}
function editChatroom(){
	$results = startDB("UPDATE chatrooms SET Name = '". esc($_REQUEST['name'])."', Description = '". esc($_REQUEST['desc'])."', ImgSmall = '". $_REQUEST['smallimg']."', ImgLarge = '". $_REQUEST['largeimg']."' WHERE id=" .$_REQUEST['id']);
	checkConnectionError($results);
}
function returnLargeImages(){
	$files = scandir("Images/LargeBackgrounds");
	$imgs ="";
	foreach($files as $imgFile){
		if(strpos($imgFile, ".jpg")== FALSE && strpos($imgFile, ".png")== FALSE && strpos($imgFile, ".gif")== FALSE){

		}else{
			$imgs .= "Images/LargeBackgrounds/".$imgFile .";";
		}
	}
	echo substr($imgs,0, strlen($imgs)-1);
}
function returnSmallImages(){
	$files = scandir("Images/SmallBackgrounds");
	$imgs ="";
	foreach($files as $imgFile){
		if(strpos($imgFile, ".jpg")== FALSE && strpos($imgFile, ".png")== FALSE && strpos($imgFile, ".gif")== FALSE){

		}else{
			$imgs .= "Images/SmallBackgrounds/".$imgFile .";";
		}
	}
	echo substr($imgs,0, strlen($imgs)-1);
}

?>