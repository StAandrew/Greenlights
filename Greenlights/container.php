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
                  <a href="http://www.ucl.ac.uk" class="navbar-brand">Greenlights</a>
                </div>

                <div class="navbar-collapse collapse">
                  <ul class="nav navbar-nav">
<!--                    <li class="active"><a href="http://www.ucl.ac.uk">Home</a></li>-->
                    <?php
                      $login_url = 'https://6e558e179fd9.ngrok.io/Greenlights/Greenlights/login.php';
                        if(isset($_SESSION['student_id'])) {
                            echo '<li class="inactive"><a>Welcome, ' . $_SESSION['given_name'] . '</li>';
                            echo '<li class="inactive"><a>' . substr($_SESSION['student_id'], 1) . '</li>';
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