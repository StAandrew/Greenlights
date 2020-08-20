<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";
$students_name = "All_Students";
$module = "ELECLAB1";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get one students info
$sql = "SELECT id, firstname, lastname, email, course_code, year
        FROM $students_name
        ORDER BY id ASC
        LIMIT 0, 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $email = $row['email'];
        $course_code = $row['course_code'];
        $year = $row['year'];
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Create table name
$table = "s" . $id;

echo "Welcome, " . $firstname;
// Get all info from student's table
$sql = "SELECT week, session, task, group_number, rating, 
        task_expected, task_actual, 
        comment, action, meeting_date, meeting_duration
        FROM $table";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    print '<table border cellpadding="10" width="500">'; 
    //print '<tr width="100"><th colspan="3">Songs</th></tr>';
    print '<tr>
            <th>Week</th>
            <th>Session</th>
            <th>Task</th>
            <th>Group number</th>
            <th>Rating</th>
            <th>Task expected</th>
            <th>Task actual</th>
            <th>Comment</th>
            <th>Action</th>
            <th>Meeting date</th>
            <th>Meeting duration</th>
            </tr>';
    
    while ($row = $result->fetch_assoc()) {
        print '<tr>';
            print '<td>' . $row['week'] . '</td>';
            print '<td>' . $row['session'] . '</td>';
            print '<td>' . $row['task'] . '</td>';
            print '<td>' . $row['group_number'] . '</td>';
            print '<td>' . $row['rating'] . '</td>'; 
            print '<td>' . $row['task_expected'] . '</td>';
            print '<td>' . $row['task_actual'] . '</td>';
            print '<td>' . $row['comment'] . '</td>'; 
            print '<td>' . $row['action'] . '</td>'; 
            print '<td>' . $row['meeting_date'] . '</td>'; 
            print '<td>' . $row['meeting_duration'] . '</td>'; 
        print '</tr>';
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
