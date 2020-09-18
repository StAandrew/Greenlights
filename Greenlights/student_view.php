<?php
// Student view of one module
include_once("inc/enable_debug.php");

include_once("inc/start_session.php");
include_once("inc/db_connect.php");
include_once("inc/header.php");

// Check for login
if(isset($_SESSION['student_id']) || isset($_SESSION['user_id'])) {
    if (isset($_SESSION['student_id']) && isset($_SESSION['email'])) {
        $student_id = $_SESSION['student_id'];
        $email = $_SESSION['email'];
    } else if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
        $student_id = $_SESSION['user_id'];
        $email = $_SESSION['email'];
    } else {
        header('Location: login.php');
        die();
    }
} else {
    header('Location: login.php');
    die();
}

// Get hash - table name
if (isset($_GET['id'])) {
    $hash = $_GET['id'];
} else {
    echo "Error: table was not found";
    die();
}
?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Week</th>
                    <th>Session</th>
                    <th>Task</th>
                    <th>Group number</th>
                    <th>Rating</th>
                    <th>Task expected (minutes)</th>
                    <th>Task took (minutes)</th>
                    <th>Task type (Group/Individual)</th>
                    <th>Comment</th>
                    <th>Action</th>
                    <th>Meeting date</th>
                    <th>Meeting duration</th>
                </tr>
            </thead>
            <tbody>
<?php
                
// Get all info from student's table
$sql = "SELECT week, session, task, group_number, rating, task_duration, task_actual, task_type, comment, actions, meeting_date, meeting_duration
        FROM $hash";
$result = $conn->query($sql);
if ($result->num_rows > 0) {  
    while ($row = $result->fetch_assoc()) {
        print '<tr>';
            print '<td>' . $row['week'] . '</td>';
            print '<td>' . $row['session'] . '</td>';
            print '<td>' . $row['task'] . '</td>';
            print '<td>' . $row['group_number'] . '</td>';
            print '<td>' . $row['rating'] . '</td>'; 
            print '<td>' . $row['task_duration'] . '</td>';
            print '<td>' . $row['task_actual'] . '</td>';
            print '<td>' . $row['task_type'] . '</td>';
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
<?php
$conn->close();
include("inc/footer.php");
?>
