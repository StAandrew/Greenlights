<?php
include_once("inc/start_session.php");
include_once("inc/ta_check.php");
include_once("inc/db_connect.php");
include_once("inc/header.php");

if (isset($_POST['module_hash_to_save'])) {
    $module_hash_to_save = $_POST['module_hash_to_save'];
    $_POST = array();
    $sql = "SELECT student_table_hash 
                FROM $all_students_table_name
                WHERE module_hash='$module_hash_to_save'";
    $big_resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
    // for each student table
    while($big_row = mysqli_fetch_array($big_resultset)) {
        $student_table_hash = $big_row['student_table_hash'];
        $sql = "SELECT id, week, session, task, task_duration, task_type FROM $module_hash_to_save";
        $small_resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
        // for each row in module table
        while($small_row = mysqli_fetch_array($small_resultset)) {
            $id = $small_row['id'];
            $week = $small_row['week'];
            $session = $small_row['session'];
            $task = $small_row['task'];
            $task_duration = $small_row['task_duration'];
            $task_type = $small_row['task_type'];
            // update table for each student
            $sql = "UPDATE $student_table_hash SET id='$id', week='$week', session='$session', task='$task', task_duration='$task_duration', task_type='$task_type' WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "";
            } else {
                die ("Error: " . $conn->error);
            }
        }
    }
}
?>
<h3>
	<font color=grey>Your Modules</font>
</h3>
<?php
    $sql = "SELECT module_name, module_hash, student_list_hash
            FROM $all_modules_table_name
            WHERE access_user_id=$user_id";  
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
?>
    <div style="display:inline;  text-align:center; vertical-align:middle;">
        <span style="display:table-cell; float:left; margin-left:10px; vertical-align:middle; line-height: 30px;">
<?php
        echo '<h4><a href=TA_student_session_view.php?module='. $row['module_hash'] .'&student_list='. $row['student_list_hash'] .'&module_name='. $row['module_name'] .'>'. $row['module_name'] .'</a></h4>';
?>
        </span>
        <span style="display:table-cell; float:left; margin-left:10px; vertical-align:middle; line-height: 30px;">
<?php
        echo '<a href=TA_module_edit.php?module='. $row['module_hash'] .'&student_list='. $row['student_list_hash'] . '&module_name='. $row['module_name'] .'>Edit module</a><br>';
?>
        </span>
    </div>
    <br/>
    <br/>
<?php
    }
include("inc/footer.php");
?>