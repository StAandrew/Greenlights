<?php //per student view
include_once("inc/start_session.php");
include_once("inc/ta_check.php");
include_once("inc/db_connect.php");
include("inc/header.php");

// Check get arguments
if (isset($_GET['module_hash']) && isset($_GET['student_list_hash']) && isset($_GET['student_table_hash']) && isset($_GET['student_id'])) {
    $module_hash = $_GET['module_hash'];
    $student_list_hash = $_GET['student_list_hash'];
    $student_table_hash = $_GET['student_table_hash'];
    $student_id = $_GET['student_id'];
} else {
    echo "Error: get arguments was not found";
    die();
}

// Get one students info
$sql = "SELECT module_name, firstname, lastname, email, course_code, year
        FROM $all_students_table_name
        WHERE student_id = $student_id
        AND student_table_hash=\"".$student_table_hash."\"";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $module_name = $row['module_name'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $email = $row['email'];
        $course_code = $row['course_code'];
        $year = $row['year'];
    }
} else {
    echo "Error: " . $sql . "<br/>" . $conn->error;
    die();
}
echo "<h2>Module: " . $module_name ."</h2>";
echo "Student name: " . $firstname . " " . $lastname ."<br/>";
echo "Email: " . $email ."<br/>";
echo "Course code: " . $course_code ."<br/>";
echo "Year of studies: " . $year ."<br/>";
?>     
    <div id="js-helper"
         data-table-id="<?php echo htmlspecialchars($student_table_hash); ?>">
    </div>
    <div id="table_view">	
        <table id="data_table" class="table table-striped">
            <thead>
                <tr>
                    <th>Unique id</th>
                    <th class="table-week">Week</th>
                    <th>Session</th>
                    <th>Task</th>
                    <th class="table-group-number">Group number</th>
                    <th class="table-rating">Rating (Green, Amber, Red)</th>
                    <th>Task duration (minutes)</th>
                    <th>Task type(G/I)</th>
                    <th class="table-task-actual">Task took (minutes)</th>
                    <th class="table-comment">Comment</th>
                    <th class="table-actions">Future actions</th>
                    <th class="table-meeting-date">Meeting date (yyyy-mm-dd hh:mm)</th>
                    <th class="table-meeting-duration">Meeting duration (minutes)</th>
                </tr>
            </thead>
            <tbody>
<?php 
// Get all info from student's table
// Editable fields:
//  group_number
//  rating
//  task_actual
//  comment
//  actions
//  meeting_date
//  meeting_duration
$sql_query = "SELECT id, week, session, task, group_number, rating, task_duration, task_type, task_actual, comment, actions, meeting_date, meeting_duration
        FROM $student_table_hash";
$resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
while( $row = mysqli_fetch_assoc($resultset) ) {
        print '<tr id="' . $row['id'] . '">';
            print '<td>' . $row['id'] . '</td>';
            print '<td  class="table-week">' . $row['week'] . '</td>';
            print '<td>' . $row['session'] . '</td>';
            print '<td>' . $row['task'] . '</td>';
            if ($row['group_number'] == 0)
                print '<td class="table-group-number"> </td>';
            else
                print '<td  class="table-group-number">' . $row['group_number'] . '</td>';
            print '<td class="table-rating">' . $row['rating'] . '</td>'; 
            print '<td>' . $row['task_duration'] . '</td>';
            print '<td>' . $row['task_type'] . '</td>';
            print '<td class="table-task-actual">' . $row['task_actual'] . '</td>';
            print '<td class="table-comment">' . $row['comment'] . '</td>'; 
            print '<td class="table-actions">' . $row['actions'] . '</td>'; 
            if ($row['meeting_date'] != null)
                print '<td class="table-meeting-date">' . date_format(date_create($row['meeting_date']), 'Y-m-d H:i') . '</td>';
            else
                print '<td class="table-meeting-date"></td>';
            print '<td class="table-meeting-duration">' . $row['meeting_duration'] . '</td>'; 
        print '</tr>';
}
?>
            </tbody>
            </table>
        </div>
        <div style="margin:50px 0px 0px 0px;">
            <form action="inc/export_student_csv.php" method="post">
                <input type='hidden' name='export_student_id' value='<?php echo $student_id;?>' />
                <input type='hidden' name='export_table_hash' value='<?php echo $module_hash;?>' />
                <input type='hidden' name='export_student_list_hash' value='<?php echo $student_list_hash;?>' />
                <input type="submit" name="export_module" value="Save as .csv file"/>
            </form>
        </div>
        <script 
                type="text/javascript" 
                src="js/per_student_view_helper.js">
        </script>
<?php
include('inc/footer.php');
$conn->close();
// add export feature
?>
