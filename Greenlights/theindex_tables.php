<?php		
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";

//debug enabled
error_reporting(E_ALL);
ini_set('display_errors',1);

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful";
}
    $sql = "CREATE TABLE IF NOT EXISTS developers (
      id int(11) NOT NULL,
      name varchar(255) NOT NULL,
      skills varchar(255) NOT NULL,
      address varchar(255) NOT NULL,
      gender varchar(255) NOT NULL,
      designation varchar(255) NOT NULL,
      age int(11) NOT NULL)";
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully<br/>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $sql = "INSERT INTO developers (id, name, skills, address, gender, designation, age) VALUES
    (1 , 'Smith', 'Java', 'Newyork', 'Male', 'Software Engineer', 34),
    (2, 'David', 'PHP', 'London', 'Male', 'Web Developer', 28),
    (3, 'Rhodes', 'jQuery', 'New Jersy', 'Male', 'Web Developer', 30),
    (4, 'Jay', 'PHP', 'Delhi, India', 'Male', 'Web Developer', 30);";
        
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully<br/>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    
$conn->close();
?>