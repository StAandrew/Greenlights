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
    $table = "s" . $id;
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];

    
    // Create table. Example table name "s18365826"
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        num INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(128) DEFAULT NULL,
        lastname VARCHAR(128) DEFAULT NULL,
        email VARCHAR(128) DEFAULT NULL,
        
        week INT(2) UNSIGNED NOT NULL,
        session VARCHAR(128) NOT NULL,
        task VARCHAR(256) NOT NULL,
        rating ENUM('Green', 'Amber', 'Red') DEFAULT NULL,
        comment VARCHAR(256) DEFAULT NULL,
        date DATETIME DEFAULT NULL,
        duration INT(3) DEFAULT NULL
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table $table created successfully<br/>";
    } else {
        echo "Error creating $table table: " . $conn->error;
        break;
    }
    
    // Used to insert first row with extra information
    $init = 0;
    
    // Add info from modules table
    foreach ($conn->query("SELECT week, session, task FROM $module") as $row) {
        $week = $row['week'];
        $session = $row['session'];
        $task = $row['task'];
        // If table is empty, add firstname, lastname, email
        if (!$init) {
            $sql = "INSERT INTO $table (firstname, lastname, email, week, session, task)
                VALUES ('$firstname', '$lastname', '$email', '$week', '$session', '$task')";
            $init = 1;
        } else {
            $sql = "INSERT INTO $table (week, session, task)
                VALUES ('$week', '$session', '$task')";
        }
        
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
?>