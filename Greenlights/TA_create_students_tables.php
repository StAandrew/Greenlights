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

// Create table for each student named by their student id
foreach ($conn->query("SELECT id, firstname, lastname, email FROM $students_name") as $row) {
    $id = $row['id'];
    
    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS $id (
        firstname VARCHAR(128) NOT NULL,
        lastname VARCHAR(128) NOT NULL,
        email VARCHAR(128),
        week INT(2) UNSIGNED PRIMARY KEY,
        session VARCHAR(128) NOT NULL,
        task1 VARCHAR(128) NOT NULL
    )";
    if ($conn->query($sql) === TRUE) {
        echo "Table $id created successfully<br/>";
    } else {
        echo "Error creating $id table: " . $conn->error;
        break;
    }
    
    // Add name and email
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    $sql = "INSERT INTO $id (firstname, lastname, email)
        VALUES ('$first_name', '$last_name', '$email')";
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully<br/>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        break;
    }
    foreach ($conn->query("SELECT week, session, task1 FROM $module") as $module_row) {
        $week = $module_row['week'];
        $session = $module_row['session'];
        $task1 = $module_row['task1'];
        
        $sql = "INSERT INTO $id (week, session, task1)
        VALUES ('$week', '$session', '$task1')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        break;
        }
    }
    
    //TODO: Get task2, task3, etc. if they exist and add them
}

// Close the connection
$conn->close();
?>