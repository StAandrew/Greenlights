<?php
include_once("../enable_debug.php");
include_once("../db_connect.php");

// Create all modules table
$sql = "CREATE TABLE IF NOT EXISTS $all_modules_table_name (
    num INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    module_name VARCHAR(128) NOT NULL,
    module_hash VARCHAR(70) NOT NULL,
    access_user_id INT(10) UNSIGNED NOT NULL,
    access_user_type ENUM('Lecturer', 'TA', 'Student', 'admin'),
    student_list_hash VARCHAR(70) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
  echo "Table created successfully<br/>";
} else {
  echo "Error creating table: " . $conn->error;
}

// Create all students table
$sql = "CREATE TABLE IF NOT EXISTS $all_students_table_name (
    num INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id INT(10) UNSIGNED NOT NULL,
    firstname VARCHAR(128) NOT NULL,
    lastname VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    course_code VARCHAR(10) NOT NULL,
    year SMALLINT(2) NOT NULL,
    module_name VARCHAR(128) NOT NULL,
    module_hash VARCHAR(70) NOT NULL,
    student_table_hash VARCHAR(70) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
  echo "Table created successfully<br/>";
} else {
  echo "Error creating table: " . $conn->error;
}

?>