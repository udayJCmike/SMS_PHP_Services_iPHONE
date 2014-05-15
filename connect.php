<?php
$dbhost							= "localhost:8889";
$dbuser							= "root";
$dbpass							= "root";
$dbname							= "deemsyspro_deem";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting to database");
echo $conn;
mysql_select_db($dbname);
?>