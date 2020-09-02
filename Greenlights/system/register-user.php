<?php


function registerUser($email, $user_password, $user_type, $firstname, $lastname, $user_id) {
    require __DIR__ . '/../inc/db_connect.php';
    require __DIR__ . '/../inc/enable_debug.php';
    echo $user_password;
    $salt = "1F1XPkkBxcO9OmXUgSSlsExIos70CyWLirEqEWMbug8YYNLmtYz25ToVhCyZK9SuVpidelpk21RE1pTYMVPKOo6jFq7k77zJAgAC0Ce6c4BAMxj622i6MHk4VjSK0y8e";
    $user_password = hash('sha256', $salt.$user_password);

    // Create table
    $sql = "SELECT user_id 
            FROM $credentials_table_name 
            WHERE email='$email' 
            LIMIT 0,1";
    $result = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
    if($result->num_rows > 0) {
        echo "user already exists";
    } else {
        if ($user_id != "") {
            $sql = "INSERT INTO $credentials_table_name  (user_id, firstname, lastname, email, pass, user_type) VALUES ('$user_id', '$firstname', '$lastname', '$email', '$user_password', '$user_type')";
        }
        else
            $sql = "INSERT INTO $credentials_table_name  (firstname, lastname, email, pass, user_type) VALUES ('$firstname', '$lastname', '$email', '$user_password', '$user_type')";
        if ($conn->query($sql) === TRUE) {
            $sql = "SELECT user_id 
                    FROM $credentials_table_name  
                    WHERE email='$email' 
                    LIMIT 0,1";
            $result = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
            $result = mysqli_fetch_assoc($result);
            $result = $result['user_id'];
            echo "User $email added successfully. User id: $result<br/>";
        } else {
            echo "Error inserting user $email " . $conn->error;
        }
    }
}
?>