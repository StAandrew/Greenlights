<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/styles.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!-- jQuery -->
<title>Greenlights</title>
<script type="text/javascript" src="dist/jquery.tabledit.js"></script>
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
                      session_start();
                      $login_url = 'https://6e558e179fd9.ngrok.io/Greenlights/Greenlights/login.php';
                        if(isset($_SESSION['student_id'])) {
                            echo '<li class="inactive"><a>Welcome, ' . $_SESSION['given_name'] . '</li>';
                            echo '<li class="inactive"><a>' . substr($_SESSION['student_id'], 1) . '</li>';
                            echo '<li class="inactive"><a href="' . $_SESSION['base_url'] . '?logout">Log Out</a></li>';
                        } else if(isset($_SESSION['user_id'])) {
                            echo '<li class="inactive"><a>Welcome, ' . $_SESSION['full_name'] . '</li>';
                            echo '<li class="inactive"><a>' . substr($_SESSION['user_id'], 1) . '</li>';
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