<?php
include 'config.php';
function startDB($query){
	global $dbHost;
	global $dbName;
	global $dbUsername;
	global $dbPassword;
	mysql_connect($dbHost, $dbUsername, $dbPassword);
	mysql_select_db($dbName);
	$results = mysql_query($query);
	if($results==FALSE){
		die(mysql_error());
	}
	return $results;
}
function esc($str){
	global $dbHost;
	global $dbName;
	global $dbUsername;
	global $dbPassword;
	mysql_connect($dbHost, $dbUsername, $dbPassword);
	mysql_select_db($dbName);
	return mysql_real_escape_string($str);
}
?>