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
    
    // Randomly decide how many tasks to add
    $num_of_tasks = rand(1, 5);
        
    // Generate a pseudo-random session name
    $session_name = ucfirst(generateRandomString(10));
        
    for ($task_num = 1; $task_num <= $num_of_tasks; $task_num++) {
        
        // Generate pseudo-random task name
        $task = ucfirst(generateRandomString(20));
        $task_duration = rand(30,300);
        
        // Add a record with each task
        $sql = "INSERT INTO $module (week, session, task, task_duration)
            VALUES ('$week', '$session_name', '$task', '$task_duration')";
        if ($conn->query($sql) === TRUE) {
          echo "New record created successfully<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            break;
        }
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