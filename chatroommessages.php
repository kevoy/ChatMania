<?php
include 'startdb.php';


//check if user is logged in
session_start();
if(isset($_SESSION['username']) && isset($_REQUEST['method']) && isset($_SESSION['chatroom'])){
	//send or Retrieve method(get all messages or to get recent messages)
	$method = $_REQUEST['method'];
	if($method == "all"){
		getAllMessages();

	}else if($method == "recent"){
		getRecentMessages();
	}else if($method == "send" && isset($_REQUEST['message'])){
		if(isset($_REQUEST['file']) && isset($_REQUEST['filename'])){
			sendMessage($_REQUEST['message']."!file!".$_REQUEST['filename'] );
		}else{
			sendMessage($_REQUEST['message']);
		}
		
	}else if($method == "check"){
		checkChangeChatroom();
	}else if($method == "vid"){
		createVideoCall($_SESSION['username'], $_REQUEST['videocall']);
	}else if($method == "checkrecv"){
		checkReceiveCall();
	}else if($method == "rejectcall"){
		rejectCall();
	}else if($method == "userfile"){
		uploadUserFile();
	}else if($method == "del"){
		deleteOldMessages();
	}

}else if(isset($_SESSION['username']) && isset($_REQUEST['method'])){
	$method = $_REQUEST['method'];
	if($method == "vid"){
		createVideoCall($_SESSION['username'], $_REQUEST['videocall']);
	}else if($method == "checkrecv"){
		checkReceiveCall();
	}else if($method == "rejectcall"){
		rejectCall();
	}else if($method == "userfile"){
		uploadUserFile();
	}
}
function deleteOldMessages(){
	$d = date('d') - 1;
	$yesterday=date('Y-m-'.$d.' H:i:s');
	if($d>-1){
		//$yesterday=date('Y-m-'.$d.' H:i:s');
		startDB("DELETE FROM chatroom_messages WHERE Time < '$yesterday'");
	}
	
	//echo date('Y-m-d H:i:s'). "=". date('Y-m-'.$d.' H:i:s');
	

}
function uploadUserFile(){
	$filename = $_SESSION['username']."_". $_FILES['newfile']['name'] ;
	if($_FILES['newfile']['size'] > 5000000){
		die("Error file is too large");
	}
	if(!move_uploaded_file($_FILES['newfile']['tmp_name'], "UserFiles/" .$filename)){
		die("Error Uploading File");
	}else{
		startDB("INSERT INTO userfiles VALUES ('". $filename ."', '". $_SESSION['username']."', '-')")
			or die("Error saving file to database");
			echo "file<->". $filename;
	}
}
function rejectCall(){
	startDB("UPDATE videopeers SET State = 'reject' WHERE Receiver = '".$_SESSION['username']."'");
}
function checkReceiveCall(){
	$curUser = $_SESSION['username'];
	$results = startDB("SELECT * FROM videopeers WHERE Receiver = '$curUser' ORDER BY time DESC LIMIT 0, 1;");
	$newChat = FALSE;
	while($row=mysql_fetch_array($results)){
		$tm = date('Y-m-d H:i:s');
		$tm2 = $row['time'];
		$time_diff = strtotime($tm) - strtotime($tm2);
		//echo $tm ." - ". $tm2 ." = ".$time_diff;
		if($row['State'] == "calling" && $time_diff < 300){
			$newChat = TRUE;
			echo "YES->" .$row['VideoRoomName'] ."->". getCallerImageStyle($row['Caller']) ."->".$row['Caller'];
		}
	}
	if($newChat == FALSE){
		echo "NO";
	}
	$time = date(DATE_ATOM);
	startDB("UPDATE users SET lastDetected = '$time' WHERE Name = '$curUser';");
}
function getCallerImageStyle($callerName){
	$result = startDB("SELECT * FROM users WHERE Name = '$callerName';");
	while($row = mysql_fetch_array($result)){
		$topDir = 'Images/Avatars/' ;
		if(substr($row['Image'], 0, 4) == 'user'){
			$topDir = 'Images/UserAvatars/';
		}
		$style = "background: url(\"". $topDir . $row['Image'] . "\");background-size: cover; background-position: center center;";
		return $style;
	}
}
function createVideoCall($curUser, $receiver){
	$results1 = startDB("SELECT * FROM videopeers WHERE Caller = '$curUser';");
	$results2 = startDB("SELECT * FROM videopeers WHERE Receiver = '$curUser';");
	$results3 = startDB("SELECT * FROM videopeers WHERE Caller = '$receiver';");
	$results4 = startDB("SELECT * FROM videopeers WHERE Receiver = '$receiver';");
	$time = date("Y-m-d H:i:s");
	$vidroomname = $receiver . $curUser;
	if(mysql_num_rows($results1) <1 && mysql_num_rows($results2)<1 && mysql_num_rows($results3) <1 && mysql_num_rows($results4)<1){
		startDB("INSERT INTO videopeers VALUES ('$vidroomname', '$curUser', '$receiver', '$time', 'calling');");
		echo "SUCCESS";
		$_SESSION['vidroomname'] = $vidroomname;
	}else if(mysql_num_rows($results3) <1 && mysql_num_rows($results4)<1){
		startDB("DELETE from videopeers WHERE Caller = '$curUser';");
		startDB("DELETE from videopeers WHERE Receiver = '$curUser'; ");
		startDB("INSERT INTO videopeers VALUES ('$vidroomname', '$curUser', '$receiver', '$time', 'calling');");
		echo "SUCCESS";
		$_SESSION['vidroomname'] = $vidroomname;
	}else{
		//startDB("DELETE from videopeers WHERE Caller = '$curUser';");
		//startDB("DELETE from videopeers WHERE Receiver = '$curUser'; ");
		$already_in_room = FALSE;
		//echo "yes";
		while($row = mysql_fetch_array($results3)){
			$t1 = strtotime($time);
			$t2=strtotime($row['time']);
			$time_diff = $t1 - $t2;
			//echo $time." - ". $row['time'] ." = ".$time_diff;
			if($time_diff < 300){
				$already_in_room = TRUE;
			}
		}
		while($row = mysql_fetch_array($results4)){
			$t1 = strtotime($time);
			$t2=strtotime($row['time']);
			$time_diff = $t1 - $t2;
			//echo $time." - ". $row['time'] ." = ".$time_diff;
			if($time_diff < 300){
				$already_in_room = TRUE;
			}
		}
		if($already_in_room == FALSE){
			startDB("DELETE from videopeers WHERE Caller = '$receiver';");
			startDB("DELETE from videopeers WHERE Receiver = '$receiver';");
			startDB("DELETE from videopeers WHERE Caller = '$curUser';");
		    startDB("DELETE from videopeers WHERE Receiver = '$curUser'; ");
		    startDB("INSERT INTO videopeers VALUES ('$vidroomname', '$curUser', '$receiver', '$time', 'calling');");
		    echo "SUCCESS";
		    $_SESSION['vidroomname'] = $vidroomname;
		}else{
			echo "USER_BUSY";
		}
	}
}
function checkChangeChatroom(){
	if($_SESSION['chatroom'] == $_REQUEST['chatroom']){
		echo "NOCHANGE";
	}else{
		echo "CHANGE";
	}
}
function genRandomId(){
	$id = rand(0, 1000000);
	$idResults = startDB("SELECT * FROM chatroom_messages WHERE id = '$id';");
	if(mysql_num_rows($idResults)>0){
		genRandomId();
	}else{
		return $id;
	}
}
function sendMessage($msg){
	$user = $_SESSION['username'];
	$chatroom = $_SESSION['chatroom'];
	$time = date(DATE_ATOM);
	$id = genRandomId();
	$user = esc($user);
	if(mysql_num_rows(startDB("SELECT * FROM users WHERE Name = '$user'"))>0){
		if(!startDB("INSERT INTO chatroom_messages VALUES ('$id', '$user', '$chatroom', '". esc($msg)."', '$time');")){
			echo "Error ". mysql_error();
		}else{
			echo "SUCCESS";
		}
		startDB("UPDATE users SET lastDetected = '$time' WHERE Name = '$user';");
	}else{
		echo "BLOCKED";
		unset($_SESSION['username']);
		
	}
	
}
function getAllMessages(){
	
	//Return all messages
	$chatroom = $_SESSION['chatroom'];
	$results = startDB("SELECT * FROM chatroom_messages JOIN users ON chatroom_messages.User = Name WHERE chatroom = '$chatroom' ORDER BY Time Desc LIMIT 0, 10;");

	//Setlast message date
	$lastMessage = true;
	$messages='';
	while($row = mysql_fetch_array($results)){
		if($_SESSION['username'] == $row['User']){
			$messages = wrapDesignMessage(htmlspecialchars($row['Message']), $row['Image'], $row['User'], $row['Sex'], TRUE) . $messages;
		}else{
			$messages = wrapDesignMessage(htmlspecialchars($row['Message']), $row['Image'], $row['User'], $row['Sex'], FALSE) . $messages;
		}
		
		if($lastMessage == true){
			$_SESSION['lastMessageDate'] = $row['Time'];
			$lastMessage = false;
		}
		
	}
	echo $messages;
	//echo $_SESSION['lastMessageDate'];
}
function wrapDesignMessage($msg, $img, $name, $sex, $curUser){
	$message= "";
	if(strpos($msg, "[emo:")>=0){
		$files = scandir("Images/Emoticons");
		foreach($files as $fil){
			if(strpos($fil, ".png")!=FALSE){
				$fTxt = "[emo:" .str_replace(".png", "", $fil) ."]";
				$msg = str_replace($fTxt, "<div style='display:inline-block; width:30px; height:30px; background:url(\"Images\/Emoticons\/$fil\")  no-repeat; background-size:cover;background-position:center center;'></div>", $msg);
			}
		}
	}
	$topDir = 'Images/Avatars/' ;
	if(substr($img, 0, 4) == 'user'){
		$topDir = 'Images/UserAvatars/';
	}
	$style = "background: url(\"". $topDir . $img . "\");background-size: cover; background-position: center center;";
	$userImgClass = 'userBoxImage2';
	if($curUser == TRUE){
		$message .= "<div id='me' class='userChatHolder'>";
		$message .=  "<div class='curUserChatHolderInner'>";
		$message .=  "<div class='curUserChatHolderTxt'>";
		$userImgClass = 'userBoxImage1';
	}else{
		$message .= "<div id='user1' class='userChatHolder'>";
		$message .=  "<div class='userChatHolderInner'>";
		$message .=  "<div class='userChatHolderTxt'>";
		$userImgClass = 'userBoxImage2';
	}
	//$message .=  "<div class='cloud'></div>";
	if(strpos($msg, "!file!")== FALSE){
		$message .=  "<a> $msg <br><span class=\"nameSmall\">~ $name [$sex]</span> </a>";
	}else{
		$fName = explode("!file!", $msg);
		$msg = $fName[0];
		$fName = $fName[1];
		$message .=  "<a> $msg<br><a style='display: block; font-size:11px; text-decoration:none; margin:0px auto; width:auto; padding:3px 2px 3px 2px; border:2px solid #7B7BFF; border-left:15px solid #7B7BFF;' href='UserFiles/". $fName."'> $fName </a> <span class=\"nameSmall\">~ $name [$sex]</span> </a>";
	}
	
	$message .=  "</div>";
	$message .=  "<div style='" .$style ."' class='" . $userImgClass ."'>";
	$message .=  "</div>";
	$message .=  "</div>";
	$message .=  "</div>";
	return $message;
}

function getRecentMessages(){
	//Retrieve recent messages based on last message date
	$chatroom = $_SESSION['chatroom'];
	$time = "";
	if(isset($_SESSION['lastMessageDate'])){
		$time = $_SESSION['lastMessageDate'];
	}
	
	$results = startDB("SELECT * FROM chatroom_messages JOIN users ON chatroom_messages.User = Name WHERE chatroom = '$chatroom' AND Time > '$time' ORDER BY Time Desc LIMIT 0, 10;");

	//Setlast message date
	$lastMessage = true;
	$messages='';
	while($row = mysql_fetch_array($results)){
		if($_SESSION['username'] == $row['User']){
			$messages = wrapDesignMessage(htmlspecialchars($row['Message']), $row['Image'], $row['User'], $row['Sex'], TRUE) . $messages;
		}else{
			$messages = wrapDesignMessage(htmlspecialchars($row['Message']), $row['Image'], $row['User'], $row['Sex'], FALSE) . $messages;
		}
		if($lastMessage == true){
			$_SESSION['lastMessageDate'] = $row['Time'];
			$lastMessage = false;
		}
		
	}
	echo $messages;
	//echo $_SESSION['lastMessageDate'];

	//If recent messages are over ten(10) raise error to javascript to call on Retrive all messages(similar to reloading the page)s
}

?>