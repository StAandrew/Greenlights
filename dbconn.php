
<?php
$mysql_db_hostname = "localhost";
$mysql_db_user = "root";
$mysql_db_password = "12345";
$mysql_db_database = "dynamicfield";

$connection = mysql_connect($mysql_db_hostname, $mysql_db_user, $mysql_db_password) or die("Could not connect database");
mysql_select_db($mysql_db_database, $connection) or die("Could not select database");
?>