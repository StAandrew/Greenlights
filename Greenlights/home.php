<?php
include("header.php");

if(isset($_GET['logout'])) {
    $base_url = $_SESSION['base_url'];
    session_destroy();
    header('Location: ' . $base_url);
    die();
}
echo "Welcome";
echo "[DEBUG] Output saved session variables";
foreach ($_SESSION as $key=>$val)
    echo $key." ".$val."<br/>";
if(isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == "Student") {
        header('Location: student_view.php');
    } else if ($_SESSION['user_type'] == "TA") {
        header('Location: TA_student_session_view.php');
    } else if ($_SESSION['user_type'] == "Lecturer") {
        echo "Lecturer";
    } else if ($_SESSION['user_type'] == "admin") {
        echo "admin";
    }
} else {
    // Redirect to login
    if (isset($_SESSION['base_url']))
        header('Location: login.php');
    else
        echo "Please log in";
}

include("footer.php");
?>