<?php
include 'startdb.php';
session_start();
if(isset($_SESSION['username']) && isset($_REQUEST['up-img']) && isset($_REQUEST['room'])){
	if($_REQUEST['up-img'] == 'user'){
		if($_FILES['file']['name'] != ''){
			$randID = rand(0,100000);
			$avatarName = "user" . $randID . $_FILES['file']['name'];
			copy($_FILES['file']['tmp_name'], "Images/UserAvatars/" . $avatarName ) or die('Could not upload file');
			if(startDB("UPDATE users SET Image = '$avatarName' WHERE Name = '". $_SESSION['username'] ."';")){
				//echo 'yes';
				$_SESSION['userImage'] = $avatarName;
			}
		}else{
			header("Location: chatroom.php?room=".$_REQUEST['room']);
			//echo 'no';
		}
	}
	header("Location: chat.php?room=".$_REQUEST['room']);
	
	
}else{
	header("Location: index.php");
}

?>