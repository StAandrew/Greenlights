<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";
$table_name = "credentials";

error_reporting(E_ALL); 
ini_set('display_errors',1); 


$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = "ucl@ta";
$password = "ucladmin";
$user_type = "TA";
$name = "Name";
$surname = "Surname";

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
    $sql = "INSERT INTO $table_name (name, surname, email, password, user_type) VALUES ('$name', '$surname', '$email', '$password', '$user_type')";
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
?>