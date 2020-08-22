<?php
$mysqli= new mysqli ("localhost","root","root","Greenlights");
if (!$mysqli)
    die ("Could not connect to database");
if (isset($_REQUEST['save']))
{
 $session=$_REQUEST['session'];
 $task=$_REQUEST['task'];

 $mysqli->query("Insert into Course (Session,Task) values ('$session','$task')");
}
 
?>