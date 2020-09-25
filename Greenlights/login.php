<?php
include_once("inc/enable_debug.php");
include("inc/start_session.php");
include_once("inc/db_connect.php");

// Based on UCL API, app name: Greenlights
$client_id = '7769165282747628.1902479455015575';
$client_secret = 'da4288765c62d139401edae69469e051c986b2efd7b5d43e9e46a21aed65c040';
$credentials_table = "credentials";

// UCL API endpoints
$authorise_endpoint = 'https://uclapi.com/oauth/authorise';
$token_endpoint = 'https://uclapi.com/oauth/token';
$data_endpoint = 'https://uclapi.com/oauth/user/data';
$student_id_endpoint = 'https://uclapi.com/oauth/user/studentnumber';

// User pressed log out
if(isset($_GET['logout'])) {
    $login_url = $_SESSION['login_url'];
    session_destroy();
    exit(header('Location: ' . $login_url));
}

// UCL login - if there is a student_id, they are logged in, and we show the logged-in view
if(isset($_SESSION['student_id'])) {
    if (isset($_SESSION['state']))
        unset($_SESSION['state']);
    if(isset($_SESSION['redirect'])) {
        $redirect = $_SESSION['redirect'];
        unset($_SESSION['redirect']);
        exit(header('Location: ' . $redirect));
    }
    
    // Display welcome message - logged in via UCL
    include("inc/header.php");
?>
    <div class="welcome-login-text"><p>Welcome, <?php echo $_SESSION['given_name']; ?></p>
    <p><a href="./home.php">Home</a></p>
    <p>Student id: <?php echo $_SESSION['student_id'];?></p>
    <p>Logged in as <?php echo $_SESSION['full_name']?></p>
    <p><a href="./login.php?logout">Log Out</a></p>
    </div>
<?php
}

// Standard login - if already logged in
else if(isset($_SESSION['user_id'])) {
    if (isset($_SESSION['state']))
        unset($_SESSION['state']);
    if(isset($_SESSION['redirect'])) {
        $redirect = $_SESSION['redirect'];
        unset($_SESSION['redirect']);
        exit(header('Location: ' . $redirect));
    }
    
    // Display welcome message - logged in via form
    include("inc/header.php");
?>
    <div class="welcome-login-text"><p>Welcome, <?php echo $_SESSION['full_name']; ?></p>
    <p><a href="./home.php">Home</a></p>
    <p>User id: <?php echo $_SESSION['user_id'];?></p>
    <p>Logged in as <?php echo $_SESSION['full_name']?></p>
    <p><a data-toggle="modal" data-target="#changePasswordModal" style="cursor: pointer">Change password</a></p>
    <p><a href="./login.php?logout">Log Out</a></p>
    </div>

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
<?php
}

// Standard login - if initialised login
else if(isset($_POST["email"]) && isset($_POST["password"])){
    
    // Raise error if states mismatch - security issue
    if($_SESSION['state'] != $_POST['state']) {
        echo "[DEBUG] Session state: " . $_SESSION['state'] . "<br/>";
        echo "[DEBUG] Get state: " . $_GET['state'] . "<br/>";
        echo "[DEBUG] Post state: " . $_POST['state'] . "<br/>";
        die('Authorization server returned an invalid state parameter');
    }
    
    $email = "";
    $password = "";
    $email = $_POST["email"];
    $password = $_POST["password"];
    $_POST = array(); // Remove post arguments for security
    $salt = "1F1XPkkBxcO9OmXUgSSlsExIos70CyWLirEqEWMbug8YYNLmtYz25ToVhCyZK9SuVpidelpk21RE1pTYMVPKOo6jFq7k77zJAgAC0Ce6c4BAMxj622i6MHk4VjSK0y8e";
    $password = hash('sha256', $salt.$password);
    
    // Cheking if user exists in a database
    $mysqli = new mysqli("localhost", "root", "root", "TA_development");
    if ($mysqli->connect_errno) {
        showAlert("Database error: Failed to connect");
    }
    $stmt = $mysqli->prepare('SELECT user_type, user_id FROM '. $credentials_table .' WHERE email = ?');
    if (!$stmt) {
        showAlert("Stmt email prepare failed");
    }
    $stmt->bind_param("s", $email);
    if (!$stmt) {
        showAlert("Stmt email bind failed");
    }
    $stmt->execute();
    if (!$stmt) {
        showAlert("Stmt email execute failed");
    }
    if (!empty($stmt->fetch())) {
        $stmt->close();
        
        $name = "";
        $surname = "";
        $user_type = "";
        $user_id = "";
        
        // Cheking if passwords match
        $stmt = $mysqli->prepare('SELECT firstname, lastname, user_type, user_id FROM '. $credentials_table .' WHERE email = ? AND pass = ?');
        if (!$stmt) {
            showAlert("Stmt email password prepare failed");
        }
        $stmt->bind_param("ss", $email, $password);
        if (!$stmt) {
            showAlert("Stmt email password bind failed");
        }
        $stmt->execute();
        if (!$stmt) {
            showAlert("Stmt email password execute failed");
        }
        $stmt->bind_result($name, $surname, $user_type, $user_id);
        if (!$stmt) {
            showAlert("Stmt email password bind result failed");
        }
        if (!empty($stmt->fetch())) {
            
            // Email and password match - get user data from database
            $_SESSION['email'] = $email;
            $_SESSION['user_type'] = $user_type; //types: TA Lecturer admin Student
            $_SESSION['user_id'] = $user_id; //100000001
            $_SESSION['full_name'] = $name . " " . $surname;
            unset($_SESSION['state']);
            $stmt->free_result();
            $stmt->close();
            $mysqli->close();
            exit(header('Location: ' . $_SESSION['login_url']));
        } else {
            showAlert("Wrong password");
        }
    } else {
        showAlert("User was not found");
    }
    $stmt->close();
    $mysqli->close();
}

// UCL login - after we got the code from UCL API
else if(isset($_GET['code']) && !isset($_SESSION['student_id'])) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // Check for errors
    if($_SESSION['state'] != $_GET['state']) {
        echo "[DEBUG] Session state: " . $_SESSION['state'] . "<br/>";
        echo "[DEBUG] Get state: " . $_GET['state'] . "<br/>";
        echo "[DEBUG] Post state: " . $_POST['state'] . "<br/>";
        die('Authorization server returned an invalid state parameter');
    }
    if(isset($_GET['error'])) {
      die('Authorization server returned an error: ' . htmlspecialchars($_GET['error']));
    }
//    echo "Result: " . $_GET['result'] . "<br/>";
//    echo "Client_id: " . $_GET['client_id'] . "<br/>";
//    echo "State: " . $_GET['state'] . "<br/>";
//    echo "Code: " . $_GET['code']. "<br/>";
    
    $token_url = $token_endpoint.'?'.http_build_query([
        'client_id' => $client_id,
        'code' => $_GET['code'],
        'client_secret' => $client_secret,
    ]);
    
    curl_setopt($ch, CURLOPT_URL, $token_url);
    $response = curl_exec($ch);
    $json_response = json_decode($response, true);
    
    if (!$json_response['ok']) {
        die('Authorization error: ' . $json_response['error']);
    } else {
        $token = $json_response['token'];
        $data_url = $data_endpoint.'?'.http_build_query([
            'token' => $token,
            'client_secret' => $client_secret,
        ]);
        curl_setopt($ch, CURLOPT_URL, $data_url);
        $response = curl_exec($ch);
        $json_response = json_decode($response, true);
        if (!$json_response['ok']) {
            die('Authorization error: ' . $json_response['error']);
        } else {
            $email = $json_response['email'];
            $full_name = $json_response['full_name'];
            $given_name = $json_response['given_name'];
            $department = $json_response['department'];
            $upi = $json_response['upi'];
            $scope_number = $json_response['scope_number'];
            $_SESSION['email'] = $email;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['given_name'] = $given_name;
            $_SESSION['department'] = $department;
            $_SESSION['upi'] = $upi;
            $_SESSION['scope_number'] = $scope_number;
            $_SESSION['user_type'] = "Student";
            
            $student_id_url = $student_id_endpoint.'?'.http_build_query([
                'token' => $token,
                'client_secret' => $client_secret,
            ]);
            curl_setopt($ch, CURLOPT_URL, $student_id_url);
            $response = curl_exec($ch);
            $json_response = json_decode($response, true);
            if (!$json_response['ok']) {
                die('Authorization error: ' . $json_response['error']);
            } else {
                $student_id = $json_response['student_number'];
                // UCL API gives us 9 digits in format 019289473
                // We use just 8 digits and dont need the first 0
                $student_id = substr($student_id, 1);
                $_SESSION['student_id'] = $student_id;
                //echo "student_id set: " . $student_id;
            }
            curl_close($ch);
            exit(header('Location: ' . $_SESSION['login_url']));
        }
    }
}

// Display both login options
else if(!isset($_SESSION['student_id']) && !isset($_SESSION['user_id'])) {
    
    // UCL login - generate option to log in. Send request to get code
    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ""){
        $redirect = $_SERVER['HTTP_REFERER'];
        $res = TRUE;
        // Additional URL checker, doesn't work, needs testing        
//        $cleaned_url = preg_replace('/[^a-z ]+/i', '', strtolower($redirect));
//        $pattern = '/troester/';
//        $res = preg_match($pattern, $cleaned_url);
    } else {
        $res = FALSE;
    }
    //session_destroy();
    //session_start();
    if ($res == true) {
        //$_SESSION['redirect'] = $redirect;
    }
    
    // determine if we use http or https
    $isSecure = false;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $isSecure = true;
    }
    else if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
        $isSecure = true;
    }
        
    // localhost and port auto-detect for development environments
    if ($_SERVER['SERVER_NAME'] == "localhost")
        $port = ':' . $_SERVER['SERVER_PORT'];
    else
        $port = '';
    
    // Login url used for proper logout function
    $schema = $isSecure ? "https" : "http";
    $schema .= "://";
    $_SESSION['login_url'] = $schema . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
    
    // Generate a random state for security
    $_SESSION['state'] = bin2hex(random_bytes(5));

    // UCL SSO Authorise endpoint
    $authorise_url = $authorise_endpoint.'?'.http_build_query([
        'client_id' => $client_id,
        'state' => $_SESSION['state'],
    ]);
    include("inc/header.php");
?>
    <center>
    <p class="welcome-login-text">
        <h1>Welcome to Greenlights feedback system</h1>
    <p>
        <hr>
            <p>
                <br>
                <span>
                    <table cellspacing="10" border="1" rules=none class="login-table">
                        <tr bgcolor=silver>
                            <td>
                                <b>Portal Log-in</b>
                            </td>  
                        </tr>
                        <tr>
                            <td>
                                <b>Greenlights is supported from Monday to Friday between 10am and 4pm, UK time.</b>
                            </td>
                        </tr>
                        <form method="post">
                        <input type='hidden' name='state' value='<?php echo $_SESSION['state'];?>' />
                        <tr>
                            <td>
                                <label>Email:</label>
                                <input type="email" name="email" class="form-control" size=100 required />  
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Password:</label>
                         <input type="password" name="password" class="form-control" size=100 required /> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                    <input type="submit" name="login" value="Login" class="login-other" />  
                                </center>
                                <hr>
                             </td>           
                        </tr>
                        </form>
                        <tr>
                            <td>
                                <center>
                                     <span>
                                        <a href="<?php echo $authorise_url;?>">
                                            <button class="login-via-ucl" style="vertical-align:middle" href="<?php echo $authorise_url;?>"><span>Login via UCL (students only)</span></button>
                                        </a>
                                    </span>
                                </center>
                            </td>
                        </tr>
                    </table>           
                </span>
            </p>  
    </center>
<?php
}

//echo "[DEBUG] Output saved session variables<br/>";
//foreach ($_SESSION as $key=>$val)
//    echo $key." ".$val."<br/>";
include("inc/footer.php");

// Helping functions
function showAlert($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
    exit(header('Location: ' . $_SESSION['login_url']));
}
?>