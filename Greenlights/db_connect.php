<?php
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "TA_development";

$abc = "abc";
// Variables
$all_modules_table_name = "all_modules";
$all_students_table_name = "all_students";
$credentials_table_name = "credentials";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>