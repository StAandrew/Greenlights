<?php
include_once("db_connect.php");
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";
$students_name = "All_Students";
$module = "ELECLAB1";
?>
<?php include("header.php");?>
    <title>Student view</title>
<?php include('container.php'); ?>
    <body>
<?php
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
        
print "Welcome, " . $firstname;
?>
        <div class="container home">
            <table width="500" class="table table-striped">
                <thead>
                <tr>
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
                </tr>
            </thead>
            <tbody>
<?php
                
// Create table name
$table = "s" . $id;
// Get all info from student's table
$sql = "SELECT week, session, task, group_number, rating, 
        task_expected, task_actual, 
        comment, actions, meeting_date, meeting_duration
        FROM $table";
$result = $conn->query($sql);
if ($result->num_rows > 0) {  
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
            print '<td>' . $row['actions'] . '</td>'; 
            print '<td>' . $row['meeting_date'] . '</td>'; 
            print '<td>' . $row['meeting_duration'] . '</td>'; 
        print '</tr>';
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
                </tbody>
            </table>
        </div>
</body>
</html>

<?php
$conn->close();
?>
