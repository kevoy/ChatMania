<?php
include 'startdb.php';
session_start();
$username = $_REQUEST['username'];
$password = $_REQUEST['userpassword'];
$sex = $_REQUEST['sex'];
$room = $_REQUEST['room'];
//mysql_connect($dbHost, $dbUsername, $dbPassword);
//mysql_select_db($dbName);
$nameAvailable = TRUE;
$results = startDB('SELECT * FROM users');
while($row=mysql_fetch_array($results)){
	if($username==$row['Name']){
		$nameAvailable = FALSE;
	}
}
if($nameAvailable == FALSE){
	echo "Unavailable";

}else{
	
	startUser($username, $sex, $room, $password);
	$_SESSION['username'] = $username;
	echo "Success";
}

function startUser($username, $sex, $room, $password){
	//mysql_connect('localhost', 'root');
	//mysql_select_db('ChatMania');
	$files = scandir("Images/Avatars");
	$randNum = rand(2, count($files)-1);
	$userImage = $files[$randNum];
	$date = returnDate();
	$_SESSION['userImage'] = $userImage;
	$username = esc($username);
	$sex = esc($sex);
	$password = esc($password);
	//for($i=2; $i<count($files); $i++){
		//echo $files[$i] ."<br>";
	//}
	//echo returnDate();
	//echo $username . "<br>" .$sex."<br>" . $userImage . "<br>" . $date;
	$results = startDB("INSERT INTO users VALUES ('$username', '$password', '$sex', '$date', '$date', '$userImage', '$room')");

	
}

function returnDate(){
	 
	return date(DATE_ATOM);

}
?>