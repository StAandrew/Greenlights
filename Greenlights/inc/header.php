<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("inc/start_session.php");
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/styles.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--ta-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.tabledit.js"></script>
<!--ta end-->
    
<!--lecturer-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<!--lecturer end-->

<title>Greenlights</title>
<?php
// If user changed password
function displayalert ($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
    //echo "<script type='text/javascript'>alert('Please log out and log in again. Contact administrator if problem persists');</script>";
    $_POST = array();
}
if(isset($_POST['old_pass'])) {
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];
    $_POST = array();
    if($old_pass != "") {
        if ($new_pass != "") {
            if ($confirm_pass != "") {
                if ($new_pass == $confirm_pass) {
                    // Validate password
                    $uppercase = preg_match('@[A-Z]@', $new_pass);
                    $lowercase = preg_match('@[a-z]@', $new_pass);
                    $number    = preg_match('@[0-9]@', $new_pass);
                    if($uppercase && $lowercase && $number && strlen($new_pass) >= 8) {
                        $credentials_table = "credentials";
                        $user_id = $_SESSION['user_id'];
                        $email = $_SESSION['email'];
                        $stored_pass = "";
                        $salt = "1F1XPkkBxcO9OmXUgSSlsExIos70CyWLirEqEWMbug8YYNLmtYz25ToVhCyZK9SuVpidelpk21RE1pTYMVPKOo6jFq7k77zJAgAC0Ce6c4BAMxj622i6MHk4VjSK0y8e";
                        $old_pass = hash('sha256', $salt.$old_pass);
                        $new_pass = hash('sha256', $salt.$new_pass);
                        if ($old_pass != $new_pass) {
                            // connect
                            $mysqli = new mysqli("localhost", "root", "root", "TA_development");
                            if ($mysqli->connect_errno) {
                                displayalert ("Database error: Failed to connect: $mysqli->connect_errno");
                            }
                            // prepare
                            if (!$stmt = $mysqli->prepare('SELECT pass FROM '. $credentials_table .' WHERE user_id = ?')) {
                                displayalert ("Database error: get password prepare failed: $mysqli->errno");
                            }
                            // bind
                            if (!$stmt->bind_param("s", $user_id)) {
                                displayalert ("Database error: get password bind_param failed $stmt->errno");
                            }
                            // execute
                            if (!$stmt->execute()) {
                                displayalert ("Database error: get password execute failed $stmt->errno");
                            }
                            // bind result
                            if (!$stmt->bind_result($stored_pass)) {
                                displayalert ("Database error: get password bind_result failed $stmt->errno");
                            }
                            // fetch
                            if (!$stmt->fetch()) {
                                displayalert ("Database error: get password fetch failed $stmt->errno");
                            }
                            $stmt->close();
                            if ($old_pass === $stored_pass) {

                                // Old passwords did match

                                // Use email as additional user validation
                                // prepare
                                if (!$stmt = $mysqli->prepare('UPDATE '. $credentials_table .' SET pass = ? WHERE user_id = ? AND email = ?')) {
                                    displayalert ("Database error: set password prepare failed: $mysqli->errno");
                                }
                                // bind param
                                if (!$stmt->bind_param("sss", $new_pass, $user_id, $email)) {
                                    displayalert ("Database error: get password bind_result failed $stmt->errno");
                                }
                                // execute
                                if (!$stmt->execute()) {
                                    displayalert ("Database error: get password execute failed $stmt->errno");
                                }
                                $stmt->fetch();
                                $stmt->free_result();
                                $stmt->close();

                                // Check if table was updated
                                $updated_pass = "";
                                // prepare
                                if (!$stmt = $mysqli->prepare('SELECT pass FROM '. $credentials_table .' WHERE user_id = ?')) {
                                    displayalert ("Database error: get password prepare failed: $mysqli->errno");
                                }
                                // bind
                                if (!$stmt->bind_param("s", $user_id)) {
                                    displayalert ("Database error: get password bind_param failed $stmt->errno");
                                }
                                // execute
                                if (!$stmt->execute()) {
                                    displayalert ("Database error: get password execute failed $stmt->errno");
                                }
                                // bind result
                                if (!$stmt->bind_result($updated_pass)) {
                                    displayalert ("Database error: get password bind_result failed $stmt->errno");
                                }
                                // fetch
                                if (!$stmt->fetch()) {
                                    displayalert ("Database error: get password fetch failed $stmt->errno");
                                }
                                $stmt->close();
                                if ($updated_pass === $new_pass) {
                                    echo "<script type='text/javascript'>alert('Password successfully changed');</script>";
                                    $mysqli->close();
                                } else {
                                    displayalert ("Database error: password mismatch");
                                }
                            } else {
                                displayalert ("Old password is wrong");
                            }
                        } else {
                            displayalert ("New password cannot be old password");
                        }
                    } else {
                        displayalert ("Password does not meet the requirements");
                    }
                } else {
                    displayalert ("Passwords do not match");
                }
            } else {
                displayalert ("Please confirm new password");
            }
        } else {
            displayalert ("Please specify new password");
        }
    } else {
        displayalert ("Please specify old password");
    }
}
?>
</head>
<body>
<div id="page-container">
<div id="page-container-no-footer">
<header class="header">
    <div>
        <img style="width:100%; border-width:0;" alt="UCL logo" id="logo" src="img/UCL-black.png">
<!--        <hr style="margin:0; height:5px;border-width:0;color:#252624;background-color:#252624">-->
    </div>
    <div role="navigation" class="navbar navbar-default navbar-static-top">
          <div class="container">
                <div class="navbar-header">
                  <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a href="home.php" class="navbar-brand">Greenlights</a>
                </div>

                <div class="navbar-collapse collapse">
                  <ul class="nav navbar-nav">
                    <?php
                        $login_url = 'login.php';
                        if(isset($_SESSION['student_id'])) {
                            // Logged in via UCL
                            echo '<li class="inactive"><a href="./home.php">Home</a></li>';
                            echo '<li class="inactive"><a href="./login.php">Welcome, ' . $_SESSION['given_name'] . '</a></li>';
                            echo '<li class="inactive"><a>' . $_SESSION['student_id'] . '</li>';
                            echo '<li class="inactive"><a href="./login.php?logout">Log Out</a></li>';
                        } else if(isset($_SESSION['user_id'])) {
                            // Logged in via form
                            echo '<li class="inactive"><a href="home.php">Home</a></li>';
                            echo '<li class="inactive"><a href="./login.php">Welcome, '. $_SESSION['full_name'] .'</a></li>';
                            echo '<li class="inactive"><a>'. $_SESSION['user_id'] .'</li>';
                            echo '<li class="inactive"><a href="./login.php?logout">Log Out</a></li>';
                        } else {
                            echo '<li class="inactive"><a href="./login.php">Login</a></li>';
                        }
                    ?>
                    </ul>
                </div>
          </div>
    </div>
</header>
<div id="content">