<?php
$connection = new mysqli("localhost","root","root","Greenlights");
if (! $connection){
    die("Error in connection".$connection->connect_error);
}
?>