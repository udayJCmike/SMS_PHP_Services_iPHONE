<?php


$host = "182.50.142.87:3306";
$DB_usr_name = "root";
$DB_usr_pswd = "deemsys@123";
$DB_name = "deemsyspro_deem";



// $host = "localhost";
// $DB_usr_name = "root";
// $DB_usr_pswd = "";
// $DB_name = "medication_monitor";

$con = mysql_connect($host,$DB_usr_name,$DB_usr_pswd);
mysql_select_db($DB_name,$con);


?>