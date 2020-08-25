<?php
session_set_cookie_params(3600,"/"); // in seconds
session_start();

// Based on UCL API, app name: Greenlights
$client_id = '';
$client_secret = '';

// Endpoints
$authorise_endpoint = 'https://uclapi.com/oauth/authorise';
$token_endpoint = 'https://uclapi.com/oauth/token';
$data_endpoint = 'https://uclapi.com/oauth/user/data';
$student_id_endpoint = 'https://uclapi.com/oauth/user/studentnumber';

// [DEBUG] Output saved session variables
//foreach ($_SESSION as $key=>$val)
//    echo $key." ".$val."<br/>";

// User pressed log out
if(isset($_GET['logout'])) {
    $base_url = $_SESSION['base_url'];
    session_destroy();
    header('Location: ' . $base_url);
    die();
}

// If there is a username, they are logged in, and we show the logged-in view
if(isset($_SESSION['student_id'])) {
    echo '<p>Welcome, ' . $_SESSION['given_name'] . '</p>';
    echo '<p>Logged in as ' . $_SESSION['student_id'] . '</p>'; 
    echo '<p>' . $_SESSION['username'] . '</p>';
    echo '<p><a href="' . $_SESSION['base_url'] . '?logout">Log Out</a></p>';
    die();
}

// After we got the code
else if(isset($_GET['code'])) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // Check for errors
    if($_SESSION['state'] != $_GET['state']) {
      die('Authorization server returned an invalid state parameter');
    }
    if(isset($_GET['error'])) {
      die('Authorization server returned an error: ' . htmlspecialchars($_GET['error']));
    }
    echo "Result: " . $_GET['result'] . "<br/>";
    echo "Client_id: " . $_GET['client_id'] . "<br/>";
    echo "State: " . $_GET['state'] . "<br/>";
    echo "Code: " . $_GET['code']. "<br/>";
    
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
            $name = $json_response['full_name'];
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
            
            curl_close($ch);
            header('Location: ' . $_SESSION['base_url']);
            die();
        }
    }
}

// Generate option to log in. Send request to get code
else if(!isset($_SESSION['student_id'])) {
    // Base url (with https)
    $_SESSION['base_url'] = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    
    // Generate state
    $_SESSION['state'] = bin2hex(random_bytes(5));

    // Authorise endpoint
    $authorise_url = $authorise_endpoint.'?'.http_build_query([
        'client_id' => $client_id,
        'state' => $_SESSION['state'],
    ]);
    
    echo '<p>Not logged in</p>';
    echo '<p><a href="' . $authorise_url . '">Log In</a></p>';
}
?>