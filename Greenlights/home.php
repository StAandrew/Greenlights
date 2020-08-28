<?php
include("header.php");

if(isset($_SESSION['user_id'])) {
    echo "User id set<br>";
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

if(isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == "Student") {
        echo "logged in as Student";
        header('Location: student_view.php');
    } else if ($_SESSION['user_type'] == "TA") {
        echo "logged in as TA";
        header('Location: TA_student_session_view.php');
    } else if ($_SESSION['user_type'] == "Lecturer") {
        echo "logged in as Lecturer";
        header('Location: LA_modules_list.php');
    } else if ($_SESSION['user_type'] == "admin") {
        echo "logged in as admin";
    }
} else {
    // Redirect to login
    if (isset($_SESSION['base_url']))
        header('Location: login.php');
    else
        echo "Please log in";
}

echo "[DEBUG] Output saved session variables<br/>";
foreach ($_SESSION as $key=>$val)
    echo $key." ".$val."<br/>";
foreach ($_POST as $key=>$val)
    echo $key." ".$val."<br/>";
foreach ($_GET as $key=>$val)
    echo $key." ".$val."<br/>";

include("footer.php");
?>