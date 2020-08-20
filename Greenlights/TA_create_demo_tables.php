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
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if exists, if not, create a db
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully with the name $database<br/>";
} else {
    echo "Error creating $database database: " . $conn->error;
}
$conn = new mysqli($servername, $username, $password, $database);

// Create table of students
$sql = "CREATE TABLE IF NOT EXISTS $students_name (
    id INT(8) UNSIGNED PRIMARY KEY,
    firstname VARCHAR(128) NOT NULL,
    lastname VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
  echo "Table $students_name created successfully<br/>";
} else {
  echo "Error creating $students_name table: " . $conn->error;
}

// Create an example table of a module
$sql = "CREATE TABLE IF NOT EXISTS $module (
    num INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    week SMALLINT(2) UNSIGNED NOT NULL,
    session VARCHAR(128) NOT NULL,
    task VARCHAR(256) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
  echo "Table $module created successfully<br/>";
} else {
  echo "Error creating $module table: " . $conn->error;
}

// Close the connection
$conn->close();
?>