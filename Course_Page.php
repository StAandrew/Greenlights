<?php
$add=$_REQUEST['add'];
$course_name=$_REQUEST['txt1_value'];
if(isset($add)) 
{
    $conn=mysqli_connect("localhost","root","root","Greenlights");
        if (!$conn)
            die("Could not connect".mysqli_error());
    $sql="Create Database <?php echo $course_name; ?>";
    mysqli_query($conn, $sql);
}
?>