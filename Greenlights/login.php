<?php
if (session_id() == "")
  session_start();
session_set_cookie_params(3600,"/"); // in seconds
//session_start();
include("header.php");
// Based on UCL API, app name: Greenlights
$client_id = '7769165282747628.1902479455015575';
$client_secret = 'da4288765c62d139401edae69469e051c986b2efd7b5d43e9e46a21aed65c040';
$credentials_table = "credentials";

// Endpoints
$authorise_endpoint = 'https://uclapi.com/oauth/authorise';
$token_endpoint = 'https://uclapi.com/oauth/token';
$data_endpoint = 'https://uclapi.com/oauth/user/data';
$student_id_endpoint = 'https://uclapi.com/oauth/user/studentnumber';

// User pressed log out
if(isset($_GET['logout'])) {
    $base_url = $_SESSION['base_url'];
    session_destroy();
    header('Location: ' . $base_url);
    die();
}

// UCL login - if there is a username, they are logged in, and we show the logged-in view
if(isset($_SESSION['student_id'])) {
    if(isset($_SESSION['redirect'])) {
        $redirect = $_SESSION['redirect'];
        unset($_SESSION['redirect']);
        header('Location: ' . $redirect);
    }
    echo '<div class="welcome-login-text"><p>Welcome, ' . $_SESSION['given_name'] . '</p>';
    echo '<p>Logged in as ' . $_SESSION['full_name'] . ', ' . substr($_SESSION['student_id'], 1) . '</p>'; 
    echo '<p>' . $_SESSION['username'] . '</p>';
    echo '<p><a href="' . $_SESSION['base_url'] . '?logout">Log Out</a></p></div>';
}

// Standard login - if already logged in
else if(isset($_SESSION['user_id'])) {
    if(isset($_SESSION['redirect'])) {
        $redirect = $_SESSION['redirect'];
        unset($_SESSION['redirect']);
        header('Location: ' . $redirect);
    }
    echo '<div class="welcome-login-text"><p>Welcome, ' . $_SESSION['full_name'] . '</p>';
    echo '<p>Logged in as ' . $_SESSION['full_name'] . ', ' . substr($_SESSION['user_id'], 1) . '</p>'; 
    echo '<p>' . $_SESSION['username'] . '</p>';
    echo '<p><a href="' . $_SESSION['base_url'] . '?logout">Log Out</a></p></div>';
}

// Standard login - if initialised login
else if(isset($_POST["email"]) && isset($_POST["password"])){
    //$_SESSION['base_url'] = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    if($_SESSION['state'] != $_POST['state']) {
        echo "[DEBUG] Session state: " . $_SESSION['state'] . "<br/>";
        echo "[DEBUG] Get state: " . $_GET['state'] . "<br/>";
        echo "[DEBUG] Get state: " . $_POST['state'] . "<br/>";
        
        echo "[DEBUG] Output saved session variables<br/>";
            foreach ($_SESSION as $key=>$val)
        echo $key." ".$val."<br/>";
        die('Authorization server returned an invalid state parameter');
    }
    
    include_once("db_connect.php");
    $email = $_POST["email"];
    $password = $_POST["password"];
    $_POST = array(); // Remove post arguments for security
    $salt = "1F1XPkkBxcO9OmXUgSSlsExIos70CyWLirEqEWMbug8YYNLmtYz25ToVhCyZK9SuVpidelpk21RE1pTYMVPKOo6jFq7k77zJAgAC0Ce6c4BAMxj622i6MHk4VjSK0y8e";
    $password = hash('sha256', $salt.$password);
    $mysqli = new mysqli("localhost", "root", "root", "TA_development");
    $stmt = $mysqli->prepare('SELECT user_type, user_id FROM '. $credentials_table .' WHERE email = ?');
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if (!empty($stmt->fetch())) {
        $stmt->close();
        
        $name = "";
        $surname = "";
        $user_type = "";
        $user_id = "";
        
        $stmt = $mysqli->prepare('SELECT name, surname, user_type, user_id FROM '. $credentials_table .' WHERE email = ? AND password = ?');
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->bind_result($name, $surname, $user_type, $user_id);
        if (!empty($stmt->fetch())) {
            echo "Success<br/>";
            $_SESSION['email'] = $email;
            $_SESSION['user_type'] = $user_type; //TA Lecturer admin Student
            $_SESSION['user_id'] = $user_id; //100000001
            $_SESSION['full_name'] = $name . " " . $surname;
            unset($_SESSION['state']);
            $stmt->free_result();
            $stmt->close();
            $mysqli->close();
            header('Location: '.$_SERVER['REQUEST_URI']);
            die();
        } else {
            echo "Wrong password";
        }
    } else {
        echo "User was not found";
    }
    $stmt->close();
    $mysqli->close();
}

// UCL login - after we got the code
else if(isset($_GET['code']) && !isset($_SESSION['student_id'])) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // Check for errors
    if($_SESSION['state'] != $_GET['state']) {
        echo "[DEBUG] Session state: " . $_SESSION['state'] . "<br/>";
        echo "[DEBUG] Get state: " . $_GET['state'] . "<br/>";
        echo "[DEBUG] Get state: " . $_POST['state'] . "<br/>";
        die('Authorization server returned an invalid state parameter');
        
        echo "[DEBUG] Output saved session variables<br/>";
            foreach ($_SESSION as $key=>$val)
        echo $key." ".$val."<br/>";
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
                $_SESSION['student_id'] = $student_id;
                echo "student_id set: " . $student_id;
            }
            unset($_SESSION['state']);
            curl_close($ch);
            header('Location: ' . $_SESSION['base_url']);
            die();
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
    session_destroy();
    session_start();
    if ($res == true) {
        $_SESSION['redirect'] = $redirect;
    }
    
    // Base url (with https)
    $_SESSION['base_url'] = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    
    // Generate state
    $_SESSION['state'] = bin2hex(random_bytes(5));

    // Authorise endpoint
    $authorise_url = $authorise_endpoint.'?'.http_build_query([
        'client_id' => $client_id,
        'state' => $_SESSION['state'],
    ]);
    echo '<p class="welcome-login-text">Welcome to Greenlights system<br/>Please log in:</p>';
    //echo '<p><a href="' . $authorise_url . '">Log In</a></p>';
    ?>
    <p>
        <span>
            <a href="<?php echo $authorise_url;?>">
                <button class="login-via-ucl" style="vertical-align:middle" href="<?php echo $authorise_url;?>"><span>Login via UCL</span></button>
            </a>
        </span>
        <span class="login-via-ucl-text">(recommended)</span>
    </p>
    <p>
        <button class="login-other" style="vertical-align:middle" data-toggle="modal" data-target="#myModalHorizontal">
                    <span>Other login</span>
        </button>
    </p>
    <div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" 
                        data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Login</h4>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form method="post">
                         <input type='hidden' name='state' value='<?php echo $_SESSION['state'];?>' />
                         <label>Enter Email</label>
                         <input type="email" name="email" class="form-control" />  
                         <br />  
                         <label>Enter Password</label>
                         <input type="password" name="password" class="form-control" />  
                         <br />  
                         <input type="submit" name="login" value="Login" class="btn btn-info" />  
                    </form>
                </div>
            </div>
        </div>
    </div>
        
<?php
}
echo "[DEBUG] Output saved session variables<br/>";
foreach ($_SESSION as $key=>$val)
    echo $key." ".$val."<br/>";
include("footer.php");
?>