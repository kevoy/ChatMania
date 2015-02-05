<?php

include 'startdb.php';


//check if user is logged in
session_start();
if(isset($_SESSION['username']) && isset($_REQUEST['method'])){
	if($_REQUEST['method'] == "getuser" && isset($_REQUEST['name'])){
		getUser();
	}else if($_REQUEST['method'] == "share" && isset($_REQUEST['filename']) && isset($_REQUEST['user'])){
		shareFile();
	}else if($_REQUEST['method'] == "delete" && isset($_REQUEST['filename']) && isset($_REQUEST['sender'])){
		deleteFile();
	}
}
function deleteFile(){
	if($_REQUEST['sender'] == $_SESSION['username']){
		startDB("DELETE FROM userfiles WHERE Name = '". $_REQUEST['filename']."'");
		unlink("UserFiles/".$_REQUEST['filename']);
	}
	echo "success";
}
function shareFile(){
	$results = startDB("SELECT * FROM userfiles WHERE Name = '". $_REQUEST['filename'] ."'");
	$row = mysql_fetch_array($results);
	$nms = $row['Receiver'].";".$_REQUEST['user'] ;
	$addUserResult = startDB("UPDATE userfiles SET Receiver = '$nms' WHERE Name = '".$_REQUEST['filename'] ."'");
	echo "success";
}
function getUser(){
	$results = startDB("SELECT * FROM users WHERE Name LIKE '". $_REQUEST['name'] ."%'");
	$names = "";
	$feedback = "success";
	if(mysql_num_rows($results)<1){
		$feedback ="nosuccess";
	}
	while($row=mysql_fetch_array($results)){
		$img = $row['Image'];
		$topDir = 'Images/Avatars/' ;
		if(substr($img, 0, 4) == 'user'){
			$topDir = 'Images/UserAvatars/';
		}
		$style = "background: url(\"". $topDir . $img . "\");background-size: cover; background-position: center center;";
		$names .= "<div class='name-result-box' onclick='setName(\"".$row['Name']."\", this)'>";
		$names .= "<div class='u-img' style='display:block; width:50px; height: 48px; border:1px solid #ABABAB; float:left; margin:5px 0px 5px 5px; border-radius:30px; background-color:white; $style'></div>";
		$names .= "<h3 class='u-name' onclick='setName(\"".$row['Name']."\", this.parentNode)'>".$row['Name']."</h3>";
		$names .= "</div>";
	}
		echo $feedback."<->".$names;

	
}

?>