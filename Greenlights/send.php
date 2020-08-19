<?php
$conn=mysqli_connect("localhost","root","root","Greenlights");
if (!$conn)
    echo "Could not connect to DB";
$name=$_REQUEST['name'];
$sql="Create Table IF NOT EXISTS classlist_$name(fname varchar(20), lname varchar(20))";
if(!mysqli_query($conn,$sql))
    echo "Table not created";
?>