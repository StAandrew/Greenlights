<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";
$students_name = "All_Students";
$module = "ELECLAB1";

//debug enabled
error_reporting(E_ALL); 
ini_set('display_errors',1); 

// Create connection
$mysqli = new mysqli($servername, $username, $password, $database);
if ($mysqli->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$mysqli->query('SET foreign_key_checks = 0');
if ($result = $mysqli->query("SHOW TABLES"))
{
    while($row = $result->fetch_array(MYSQLI_NUM))
    {
        $mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
    }
}

$mysqli->query('SET foreign_key_checks = 1');
echo 'Success';
// Close the connection
$mysqli->close();
?>