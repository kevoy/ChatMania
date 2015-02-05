<?php
include 'startdb.php';
session_start();
if(isset($_SESSION['username']) && isset($_REQUEST['method']) && isset($_SESSION['vidroomname'])){
	$method = $_REQUEST['method'];
	if($method == "status"){
		checkStatus();
	}else if($method == "time"){
		updateTime();
	}else if($method == "exit"){
		exitVideoChat();
	}
}
function exitVideoChat(){
	startDB("DELETE FROM videopeers WHERE VideoRoomName = '" . $_SESSION['vidroomname'] ."';");
}
function updateTime(){
	$result = startDB("SELECT * FROM videopeers WHERE VideoRoomName = '" . $_SESSION['vidroomname'] ."';");
	if(mysql_num_rows($result)<1){
		echo "cancel";
	}else{
		startDB("UPDATE videopeers SET time = '". date("Y-m-d H:i:s"). "' WHERE VideoRoomName = '" . $_SESSION['vidroomname'] ."';");
		echo "SUCCESS";
	}
	
}
function checkStatus(){
	$result = startDB("SELECT * FROM videopeers WHERE VideoRoomName = '" . $_SESSION['vidroomname'] ."';");
	while($row = mysql_fetch_array($result)){
		if($row['State'] == "calling"){
			echo "calling";
		}else if($row['State'] == "inprogress"){
			echo "inprogress";
		}else if($row['State'] == "reject"){
			echo "reject";
			startDB("DELETE FROM videopeers WHERE VideoRoomName = '" . $_SESSION['vidroomname'] ."';");
			
		}
	}
}
?>