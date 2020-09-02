<?php
include_once("../enable_debug.php");
include_once("../db_connect.php");

$email = "ucl@student";
$password = "ucladmin";
$user_type = "Student";
$name = "Name";
$surname = "Surname";
$user_id = "18293867";

function registerUser($email, $password, $user_type, $firstname, $lastname, $user_id) {
    $salt = "1F1XPkkBxcO9OmXUgSSlsExIos70CyWLirEqEWMbug8YYNLmtYz25ToVhCyZK9SuVpidelpk21RE1pTYMVPKOo6jFq7k77zJAgAC0Ce6c4BAMxj622i6MHk4VjSK0y8e";
    $password = hash('sha256', $salt.$password);

    // Create table
    $sql = "SELECT user_id 
            FROM $table_name 
            WHERE email='$email' 
            LIMIT 0,1";
    $result = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
    if($result->num_rows > 0) {
        echo "user already exists";
    } else {
        if ($user_id == "")
            $sql = "INSERT INTO $table_name (name, surname, email, pass, user_type, user_id) VALUES ('$name', '$surname', '$email', '$password', '$user_type', '$user_id')";
        else
            $sql = "INSERT INTO $table_name (name, surname, email, pass, user_type) VALUES ('$name', '$surname', '$email', '$password', '$user_type')";
        if ($conn->query($sql) === TRUE) {
            $sql = "SELECT user_id 
                    FROM $table_name 
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