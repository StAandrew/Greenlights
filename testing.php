<?php
$conn=mysqli_connect("localhost","root","root");
if (!$conn)
    echo "Could not connect";
$sql="Create Database Test";
if (mysqli_query($conn,$sql))
    echo "database created";
?>