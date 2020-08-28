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
<script type="text/javascript" src="dist/jquery.tabledit.js"></script>

<!--lecturer-->
<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>-->

<!--
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="src/jquery.table2excel.js"></script>
-->
    
<title>Greenlights</title>
<?php
// If user changed password
function displayalert ($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
    $_POST = array();
}
if(isset($_POST['old_pass']) || isset($_POST['new_pass'])) {
    if(isset($_POST['old_pass'])) {
        if (isset($_POST['new_pass'])) {
            if (isset($_POST['confirm_pass'])) {
                $new_pass = $_POST['new_pass'];
                $confirm_pass = $_POST['confirm_pass'];
                if ($new_pass === $confirm_pass) {
                    $uppercase = preg_match('@[A-Z]@', $new_pass);
                    $lowercase = preg_match('@[a-z]@', $new_pass);
                    $number    = preg_match('@[0-9]@', $new_pass);                    
                    //if($uppercase && $lowercase && $number && strlen($password) >= 8) {
                    if (true) {
                        if (session_id() == "")
                            session_start();
                        $credentials_table = "credentials";
                        $user_id = $_SESSION['user_id'];
                        $email = $_SESSION['email'];
                        $old_pass = $_POST['old_pass'];
                        $stored_pass = "";
                        $salt = "1F1XPkkBxcO9OmXUgSSlsExIos70CyWLirEqEWMbug8YYNLmtYz25ToVhCyZK9SuVpidelpk21RE1pTYMVPKOo6jFq7k77zJAgAC0Ce6c4BAMxj622i6MHk4VjSK0y8e";
                        $old_pass = hash('sha256', $salt.$old_pass);
                        // connect
                        $mysqli = new mysqli("localhost", "root", "root", "TA_development");
                        if ($mysqli->connect_errno) {
                            displayalert ("Database error: Failed to connect: $mysqli->connect_errno");
                        }
                        // prepare
                        if (!$stmt = $mysqli->prepare('SELECT pass FROM '. $credentials_table .' WHERE user_id = ?')) {
                            displayalert ("Database error: Prepare failed: $mysqli->errno");
                        }
                        // bind
                        if (!$stmt->bind_param("s", $user_id)) {
                            displayalert ("Database error: Bind param failed $stmt->errno");
                        }
                        // execute
                        if (!$stmt->execute()) {
                            displayalert ("Database error: Execute failed $stmt->errno");
                        }
                        if (!$stmt->bind_result($stored_pass)) {
                            displayalert ("Database error: Bind result failed $stmt->errno");
                        }
                        $stmt->close();
                        //!empty($stmt->fetch())

                        $message = "old pass: <br/>".$old_pass." stored pass: <br/>".$stored_pass;
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        die();
                        if ($old_pass === $stored_pass) {
                            // Old passwords match
                            $new_pass = $_POST['new_pass'];
                            $new_pass = hash('sha256', $salt.$new_pass);
                            $stmt = $mysqli->prepare('UPDATE '. $credentials_table .' SET pass = ? WHERE user_id = ?');
                            $stmt->bind_param("ss", $new_pass, $user_id);
                            $stmt->execute();
                            if (!empty($stmt->fetch())) {
                                $stmt->free_result();
                                $stmt->close();
                                $mysqli->close();
                                displayalert ("Success");
                            } else {
                                displayalert ("Error: can't connect to a database");
                            }
                        } else {
                            displayalert ("Old password is wrong");
                        }
                    } else {
                        displayalert ("Password doesn't meet the requirements");
                    }
                } else {
                    displayalert ("Passwords don't match");
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
<header class="header">
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
<!--                    <li class="active"><a href="http://www.ucl.ac.uk">Home</a></li>-->
                    <?php
                    if (session_id() == "")
                        session_start();
                      $login_url = 'login.php';
                        if(isset($_SESSION['student_id'])) {
                            echo '<li class="inactive"><a>Welcome, ' . $_SESSION['given_name'] . '</li>';
                            echo '<li class="inactive"><a>' . substr($_SESSION['student_id'], 1) . '</li>';
                            echo '<li class="inactive"><a href="' . $_SESSION['base_url'] . '?logout">Log Out</a></li>';
                        } else if(isset($_SESSION['user_id'])) {
                            echo '<li class="inactive"><a>Welcome, ' . $_SESSION['full_name'] . '</li>';
                            echo '<li class="inactive"><a>' . substr($_SESSION['user_id'], 1) . '</li>';
                            echo '<li class="inactive" style="cursor: pointer"><a data-toggle="modal" data-target="#changePasswordModal" >Change password</li>';
                            echo '<li class="inactive"><a href="' . $_SESSION['base_url'] . '?logout">Log Out</a></li>';
                        } else {
                            echo '<li class="inactive"><a href="'. $login_url .'">Login</a></li>';
                        }
                    ?>
                    </ul>
                </div>
          </div>
    </div>
</header>
<div id="content">
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Change password</h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form method="post">
                    <label>Enter Current Password</label>
                        <input type="password" name="old_pass" class="form-control" />  
                    <br/>
                    <label>Enter New Password</label>
                    <li>Must be a minimum of 8 characters<br/></li>
                    <li>Must contain at least 1 number<br/></li>
                    <li>Must contain at least one uppercase character<br/></li>
                    <li>Must contain at least one lowercase character<br/></li>
                    <br/>
                        <input type="password" name="new_pass" class="form-control" />  
                    <br/>  
                    <label>Confirm New Password</label>
                        <input type="password" name="confirm_pass" class="form-control" />  
                    <br/> 
                    <input type="submit" name="change_password" value="Change password" class="btn btn-info" />  
                </form>
            </div>
        </div>
    </div>
</div>