<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";

// Main table name
$table_name = "all_modules";

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
    hash VARCHAR(70) NOT NULL PRIMARY KEY,
    module_name VARCHAR(128) NOT NULL,
    module_hash VARCHAR(70) NOT NULL,
    access_user_id INT(10) UNSIGNED NOT NULL,
    access_user_type ENUM('Lecturer', 'TA', 'Student', 'admin'),
    student_list_hash VARCHAR(70) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
  echo "Table $table_name created successfully<br/>";
} else {
  echo "Error creating $table_name table: " . $conn->error;
}

?>