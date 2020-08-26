<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";
$table_name = "credentials";

//debug enabled
error_reporting(E_ALL); 
ini_set('display_errors',1); 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create table
$sql = "CREATE TABLE IF NOT EXISTS $table_name (
    name VARCHAR(64) NOT NULL,
    surname VARCHAR(64) NOT NULL,
    email VARCHAR(128) NOT NULL,
    password VARCHAR(128) NOT NULL,
    user_type ENUM('Lecturer', 'TA', 'Student', 'admin'),
    user_id INT(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT
)";
if ($conn->query($sql) === TRUE) {
  echo "Table $table_name created successfully<br/>";
} else {
  echo "Error creating $table_name table: " . $conn->error;
}
$sql = "ALTER TABLE $table_name AUTO_INCREMENT=100000001";
if ($conn->query($sql) === TRUE) {
  echo "Altered auto_increment<br/>";
} else {
  echo "Error creating $table_name table: " . $conn->error;
}
?>