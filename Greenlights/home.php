<?php
include_once("start_session.php");
if(isset($_SESSION['user_id'])) {
//    echo "[DEBUG] Output saved session variables<br/>";
//    foreach ($_SESSION as $key=>$val)
//        echo $key." ".$val."<br/>";
//    echo "[DEBUG] Output saved post variables<br/>";
//    foreach ($_POST as $key=>$val)
//        echo $key." ".$val."<br/>";
//    echo "[DEBUG] Output saved get variables<br/>";
//    foreach ($_GET as $key=>$val)
//        echo $key." ".$val."<br/>";
//    echo "[DEBUG] Output global variables<br/>";
//    foreach ($_GLOBAL as $key=>$val)
//        echo $key." ".$val."<br/>";
}
$lecturer_home = "LA_modules_list.php";
$ta_home = "TA_student_session_view.php";
$student_home = "student_view.php";

if(isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == "Student") {
        exit(header('Location: ' . $student_home));
    } else if ($_SESSION['user_type'] == "TA") {
        exit(header('Location: ' . $ta_home));
    } else if ($_SESSION['user_type'] == "Lecturer") {
        exit(header('Location: ' . $lecturer_home));
    } else if ($_SESSION['user_type'] == "admin") {
        echo "logged in as admin";
    }
} else {
    // Redirect to login
    if (isset($_SESSION['login_url']))
        exit(header('Location: ' . $_SESSION['login_url']));
}
include("header.php");
echo "Please log in";
echo "[DEBUG] Output saved session variables<br/>";
foreach ($_SESSION as $key=>$val)
    echo $key." ".$val."<br/>";
foreach ($_POST as $key=>$val)
    echo $key." ".$val."<br/>";
foreach ($_GET as $key=>$val)
    echo $key." ".$val."<br/>";

include("footer.php");
?>