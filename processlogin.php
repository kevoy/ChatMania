<?php
include 'startdb.php';
session_start();
$username = $_REQUEST['username'];
$password = $_REQUEST['userpassword'];
$userImage = "";
$login = FALSE;
$results = startDB('SELECT * FROM users');
while($row=mysql_fetch_array($results)){
	if($username==$row['Name'] && $password == $row['Password']){

		$login = TRUE;
		$userImage = $row['Image'];
	}
}
if($login == FALSE){
	echo "Unavailable";

}else{
	
	$_SESSION['username'] = $username;
	$_SESSION['userImage'] = $userImage;
	echo "Success";
}
?>