<?php
$course_name=$_REQUEST['course_name'];
$loginID=$_REQUEST['login'];
if (isset($course_name))
{
$conn=mysqli_connect("localhost","root","root","Greenlights");
if (!$conn)
    die ("Could not connect")
$sql="Insert into Courses Values ("")

}
?>