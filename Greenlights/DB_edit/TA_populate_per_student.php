<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";
$students_name = "All_Students";
$module = "ELECLAB1";

//debug enabled
error_reporting(E_ALL);
ini_set('display_errors',1);

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Insert into a table for each student named by their student id
foreach ($conn->query("SELECT id FROM $students_name") as $row) {
    $id = $row['id'];
    $table = "s" . $id;
    // Add info from modules table
    foreach ($conn->query("SELECT week, session, task, task_duration FROM $module") as $row) {
        $week = $row['week'];
        $session = $row['session'];
        $task = $row['task'];
        $task_expected = $row['task_duration'];
        if(rand(1, 2) == 1)
            $group_number = 1;
        else
            $group_number = 0;
        $rand_rating = rand(1, 10);
        if ($rand_rating < 2)
            $rating = "Red";
        else if ($rand_rating < 5)
            $rating = "Amber";
        else 
            $rating = "Green";
        $comment = "Some comment";
        $action = "Some action";
        $task_actual = rand(10, 90);
        $meeting_date = "2020-08-06";
        $meeting_date=date("Y-m-d",strtotime($meeting_date));
        $meeting_duration = rand(10, 60);

        $sql = "INSERT INTO $table (week, session, task, task_expected, group_number, rating, task_actual, comment, action, meeting_date, meeting_duration) VALUES ('$week', '$session', '$task', '$task_expected', '$group_number', '$rating', '$task_actual', '$comment', '$action', '$meeting_date', '$meeting_duration')";
        if ($conn->query($sql) === TRUE) {
          echo "New record created successfully<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            break;
        }
    }
}

echo "Success";
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