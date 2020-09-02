<?php
require __DIR__ . '/../system/variables.php';

$conn = mysqli_connect($servername, $server_username, $server_password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>