<?php
// Check if user is a TA
if(isset($_SESSION['user_type']) && isset($_SESSION['user_id'])) {
    if($_SESSION['user_type'] == "TA" || $_SESSION['user_type'] == "Lecturer" || $_SESSION['user_type'] == "admin") {
            $user_id = $_SESSION['user_id'];
    } else if (isset($_SESSION['login_url'])){
        exit(header('Location: ' . $_SESSION['login_url']));
    } else {
        include("header.php");
        echo "Please log in";
        include("footer.php");
        die();
    }
} else {
    include("header.php");
    echo "Please log in";
    include("footer.php");
    die();
}
?>