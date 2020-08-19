<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";
$module = "ELECLAB1";
$num_of_weeks = 10;

//debug enabled
error_reporting(E_ALL); 
ini_set('display_errors',1);

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

for ($week=1; $week <= $num_of_weeks; $week++) {
    // Generate pseudo-random data
    $session_name = ucfirst(generateRandomString(10));
    $task1 = ucfirst(generateRandomString(20));
    
//    // Add task 2 with a 50% chance
//    if (rand(1, 2) == 1)
//        $task2 = ucfirst(generateRandomString(20));
//    else
//        $task2 = NULL;
//    
//    // Check if task 2 column exists
//    $sql = ("SELECT `task2` FROM `$module`");
//    if ($conn->query($sql) === TRUE){
//        conn->query("ALTER TABLE $module ADD `task2` VARCHAR(128)");
//        echo 'task 2 has been added to the database';
//    } else {
//        echo "Error: " . $sql . "<br>" . $conn->error;
//        break;
//    }
    
    // Add a record
    $sql = "INSERT INTO $module (week, session, task1)
        VALUES ('$week', '$session_name', '$task1')";
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