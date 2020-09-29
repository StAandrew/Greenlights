<?php
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params(3600,"/"); // in seconds
    $status = session_start();
    if (!$status) {
        echo "<script type='text/javascript'>alert('Error: failed to start session');</script>";
        die();
    }
}
?>