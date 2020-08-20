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
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Drop students db
$sql = "DROP TABLE IF EXISTS $students_name, $module;";
if ($conn->query($sql) === TRUE) {
    echo "Tables were deleted<br/>";
} else {
    echo "Error deleting tables: " . $conn->error;
}

// Close the connection
$conn->close();
?>