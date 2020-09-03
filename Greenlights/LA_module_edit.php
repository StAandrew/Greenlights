<?php
include_once("inc/enable_debug.php");

include_once("inc/start_session.php");
include_once("inc/lecturer_check.php");
include_once("inc/db_connect.php");
include("inc/header.php");


// TODO: pass module name as get argument
// Get hash - table name
if (isset($_GET['module']) && isset($_GET['student_list'])) {
    $module_hash = $_GET['module'];
    $student_list_hash = $_GET['student_list'];
} else {
    echo "Error: get arguments was not found";
    die();
}

?>     
    <div id="js-helper"
         data-module-id="<?php echo htmlspecialchars($module_hash); ?>">
    </div>
    <div id="table_view">	
        <table id="data_table" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Week</th>
                    <th>Teaching event</th>
                    <th>Task</th>
                    <th>Task duration (minutes)</th>
                    <th>Task type</th>
                </tr>
            </thead>
            <tbody>
<?php
$sql = "SELECT num, week, session, task, task_duration, task_type
        FROM $module_hash";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
while( $row = mysqli_fetch_assoc($resultset) ) {
        print '<tr id="' . $row['num'] . '">';
            print '<td>' . $row['num'] . '</td>';
            print '<td>' . $row['week'] . '</td>';
            print '<td>' . $row['session'] . '</td>';
            print '<td>' . $row['task'] . '</td>';
            print '<td>' . $row['task_duration'] . '</td>';
            print '<td>' . $row['task_type'] . '</td>'; 
        print '</tr>';
}
?>
            </tbody>
        </table>
        <div style="margin:50px 0px 0px 0px;">
            <a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://ucl.ac.uk">Save</a>
        </div>
    </div>
    <script 
            type="text/javascript" 
            src="js/LA_module_edit_table_edit.js">
    </script>

<?php

// Add add TA function, save to $all_modules_table_name
// when pressed save, fetch all tables from $all_students_table_name, and update all of them

include("inc/footer.php");
?>