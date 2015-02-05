<?php
include 'config.php';
$siteTitle1 = 'Chat';
$siteTitle2 = 'Mania';
$siteDescription = "Add Your Description Here";
$siteBackground = 'images/vertical_cloth.png';
$about ='';
$contact = '';
$adsv = '';
$adsh = '';

$roomName = array();
$roomDescription = array();
$roomImgSmall = array();
$roomImgLarge = array();
$roomId = array();

mysql_connect($dbHost, $dbUsername, $dbPassword);
mysql_select_db($dbName);
$results = mysql_query('SELECT * FROM settings');
if($results==FALSE){
		die(mysql_error());
	}
while($row = mysql_fetch_array($results)){
	$t = explode("#", $row['SiteTitle']);
	$siteTitle1 = $t[0];
	$siteTitle2 = $t[1];
	//$siteTitle1 = explode('#', $row['SiteTitle'])[0];
	//$siteTitle2 = explode('#', $row['SiteTitle'])[1];
	$siteDescription = $row['SiteDescription'];
	$siteBackground = $row['SiteBackground'];
	$about = $row['About'];
	$contact = $row['Contact'];
	$adsv = $row['AdsCode'];
	$adsh = $row['AdsCodeH'];
}

//print $siteTitle1;
//print $siteTitle2;
//print $siteDescription;
//print $siteBackground;
//print $about;
//print $contact;
$results = mysql_query('SELECT * FROM chatrooms');
if($results==FALSE){
		die(mysql_error());
	}
while($row = mysql_fetch_array($results)){
	$roomName[] = $row['Name'];
	$roomDescription[] = $row['Description'];
	$roomImgSmall[] = $row['ImgSmall'];
	$roomImgLarge[] = $row['ImgLarge'];
	$roomId[] = $row['id'];
}

?>