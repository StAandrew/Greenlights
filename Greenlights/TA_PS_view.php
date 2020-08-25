<?php //per student view
session_start();
$module = $_GET['m'];
$students_name = $_GET['s'];
$student_id = $_GET['student_id'];
include_once("db_connect.php");
?>

<?php include("header.php");?>
    <title>Per Student View</title>
    <script type="text/javascript" src="dist/jquery.tabledit.js"></script>
<?php include('container.php'); ?>
    <body>
<?php
// Get one students info
$sql = "SELECT id, firstname, lastname, email, course_code, year
        FROM $students_name
        WHERE id = $student_id
        ORDER BY id DESC
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
    echo "Error: " . $sql . "<br/>" . $conn->error;
}

// Create table name
$table = "s" . $id;
// Echo student info:
print "Student name: " . $firstname . " " . $lastname . "<br/>";
print "Student id: " . $id . "<br/>";
print "Email: " . $email . "<br/>";
print "Course code: " . $course_code . "<br/>";
print "Year: " . $year . "<br/>";
?>     
    <div id="js-helper"
         data-student-id="<?php echo htmlspecialchars($student_id); ?>">
    </div>
    <div class="container home">	
        <table id="data_table" class="table table-striped">
            <thead>
                <tr>
<!--                <th>Unique id</th>-->
                    <th>Week</th>
                    <th>Session</th>
                    <th>Task</th>
                    <th>Group number</th>
                    <th>Rating</th>
                    <th>Task expected</th>
                    <th>Task actual</th>
                    <th>Comment</th>
                    <th>Actions</th>
                    <th>Meeting date</th>
                    <th>Meeting duration</th>
                </tr>
            </thead>
            <tbody>
<?php 
// Get all info from student's table
// Editable fields:
//  group_number 4
//  rating 5
//  task_actual 7
//  comment 8
//  actions 9
//  meeting_date 10
//  meeting_duration 11
$sql_query = "SELECT id, week, session, task, group_number, rating, 
        task_expected, task_actual, 
        comment, actions, meeting_date, meeting_duration
        FROM $table";
$resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
while( $row = mysqli_fetch_assoc($resultset) ) {
        print '<tr id="' . $row['id'] . '">';
            //print '<td>' . $row['id'] . '</td>';
            print '<td>' . $row['week'] . '</td>';
            print '<td>' . $row['session'] . '</td>';
            print '<td>' . $row['task'] . '</td>';
            if ($row['group_number'] == 0)
                print '<td> </td>';
            else
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
?>
            </tbody>
            </table>
            <div style="margin:50px 0px 0px 0px;">
                <a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://ucl.ac.uk">Back</a>
            </div>
        </div> 
        <script 
                type="text/javascript" 
                src="TA_PS_custom_table_edit.js">
        </script>
</body>
<?php
include('footer.php');
$conn->close();
?>
