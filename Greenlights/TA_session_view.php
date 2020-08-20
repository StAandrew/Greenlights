<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";
$students_name = "All_Students";
$module = "ELECLAB1";

// Hardcoded session name
$session = "Jpxmjxiiik";
echo "Session: " . $session;
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch sessions and tasks
$tasks = array();
$sql = "SELECT week, session, task
        FROM $module
        WHERE session = '$session'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row['task'];
        $week = $row['week'];
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Create table headers with dynamic task columns
print '<table border cellpadding="10" width="1200" >
        <tr>
            <th>Student name</th>
            <th>Student id</th>
            <th>Meeting date</th>
            <th>Overall rating</th>';
$tasknum = 1;
foreach($tasks as $item) {
    $output = "Task " . $tasknum . ": " . $item;
    print "<th>" . $output . "</th>";
    $tasknum++;
}
   print'</tr>';

// Fetch students data
$sql = "SELECT id, firstname, lastname, email, course_code, year
        FROM $students_name";
$stud_result = $conn->query($sql);
if ($stud_result->num_rows > 0) {
    // Loop through every student in the database
    while ($stud = $stud_result->fetch_assoc()) {
        $table = "s" . $stud['id'];
        $name = $stud['firstname'][0] . ". " . $stud['lastname'];
        $course_code = $stud['course_code'];
        $year = $stud['year'];
        
        print '<tr>';
        print '<td>' . $name . '</td>';
        print '<td>' . $stud['id'] . '</td>';
        $date = 0;
        // Loop through tasks
        foreach($tasks as $item) {
            $sql = "SELECT task, rating, meeting_date
                FROM $table
                WHERE task = '$item'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                    if (!$date) {
                        print '<td>' . $row['meeting_date'] . '</td>';
                        print '<td>' . 'Unknown' . '</td>';
                        $date = 1;
                    }
                    print '<td>' . $row['rating'] . '</td>';
                }
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        print '</tr>';
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

print '</table>
    </html>';

$conn->close();
?>