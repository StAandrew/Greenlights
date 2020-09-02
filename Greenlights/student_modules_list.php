<?php
include_once("enable_debug.php");

include_once("start_session.php");
include_once("db_connect.php");

// Check for login
if(isset($_SESSION['student_id']) || isset($_SESSION['user_id'])) {
    if (isset($_SESSION['student_id']) && isset($_SESSION['email'])) {
        $student_id = $_SESSION['student_id'];
        $email = $_SESSION['email'];
    } else if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
        $student_id = $_SESSION['user_id'];
        $email = $_SESSION['email'];
    } else {
        header('Location: login.php');
        die();
    }
} else {
    echo "two";
    header('Location: login.php');
    die();
}
include("header.php");

// Get all modules of this student
$sql = "SELECT firstname, lastname, year, module_name, student_table_hash
        FROM $all_students_table_name
        WHERE student_id=$student_id";
if ($result = $conn->query($sql)) {
    if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $hash = $row['student_table_hash'];
            $module_name = $row['module_name'];
            echo '<a href=student_view.php?id='. $hash .'>'. $module_name .'</a><br>';
        }
    } else {
        print "No information available yet";
        die();
    }
} else {
    print "No information available yet";
    die();
}
?>