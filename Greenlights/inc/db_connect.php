<?php
require __DIR__ . '/../system/variables.php';

$conn = mysqli_connect($servername, $server_username, $server_password, $dbname);
if (!$conn || mysqli_connect_errno()) {
    $search = 'Unknown database';
    if(preg_match("/{$search}/i", mysqli_connect_error())) {
        echo "System has not been initialised. Please contact system administrator";
    }
    else {
        echo "Connection a failed: " . mysqli_connect_error();
    }
    exit();
}
?>