<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";
$students_name = "All_Students";
$num_of_records = 10;

//debug enabled
error_reporting(E_ALL); 
ini_set('display_errors',1);

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

for ($i=0; $i < $num_of_records; $i++) {
    // Generate pseudo-random data
    $id = rand(18000000, 20000000);
    $first_name = ucfirst(generateRandomString(4));
    $last_name = ucfirst(generateRandomString(8));
    $email = generateRandomString(7);
    $email .= "@ucl.ac.uk";
    
    // Add a record
    $sql = "INSERT INTO $students_name (id, firstname, lastname, email)
        VALUES ('$id', '$first_name', '$last_name', '$email')";
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully<br/>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        break;
    }
}

// Close the connection
$conn->close();

// Function to generate a random string of a given length
function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>