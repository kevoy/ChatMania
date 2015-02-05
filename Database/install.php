<?php
include '../config.php';
// Name of the file
$filename = 'chatmania2.sql';
// MySQL host
//$dbHost = 'localhost:/tmp/mysql5.sock';
// MySQL username
//$dbUsername = 'dbo543084150';
// MySQL password
//$dbPassword = 'Finx44**0606';
// Database name
//$dbName = 'db543084150';

// Connect to MySQL server
mysql_connect($dbHost, $dbUsername, $dbPassword) or die('Error connecting to MySQL server: ' . mysql_error());
// Select database
mysql_select_db($dbName) or die('Error selecting MySQL database: ' . mysql_error());

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
if (substr($line, 0, 2) == '--' || $line == '')
    continue;

// Add this line to the current segment
$templine .= $line;
// If it has a semicolon at the end, it's the end of the query
if (substr(trim($line), -1, 1) == ';')
{
    // Perform the query
    mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
    // Reset temp variable to empty
    $templine = '';
}
}
 echo "Tables imported successfully";
?>