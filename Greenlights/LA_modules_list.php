<?php
include_once("inc/start_session.php");
include_once("inc/lecturer_check.php");
include_once("inc/db_connect.php");
include("inc/header.php");

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
        $sql = "SELECT num, week, session, task, task_duration, task_type FROM $module_hash_to_save";
        $small_resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
        // for each row in module table
        while($small_row = mysqli_fetch_array($small_resultset)) {
            $num = $small_row['num'];
            $week = $small_row['week'];
            $session = $small_row['session'];
            $task = $small_row['task'];
            $task_duration = $small_row['task_duration'];
            $task_type = $small_row['task_type'];
            // update table for each student
            $sql = "UPDATE $student_table_hash SET id='$num', week='$week', session='$session', task='$task', task_duration='$task_duration', task_type='$task_type' WHERE id='$num'";
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
        echo '<a href=LA_module_edit.php?module='. $row['module_hash'] .'&student_list='. $row['student_list_hash'] . '&module_name='. $row['module_name'] .'>'. $row['module_name'] .'</a><br>';
    }
?>
<form name=course_entry method=post action="LA_add_module_1.php" enctype="multipart/form-data">
    <h3>
        <font color=grey>Add new module</font>
    </h3>
        <p>Please enter your module name here:<br>
            <input type=text placeholder="Enter Module Name" name=module_name size=50>
        </p>
        <p>Please upload the relevant class list:<br>
            <input type="file" name="file" id="file" accept=".csv">
        </p>
        <p>Or select from existing class lists (optional)
            <select name="student_list_option"> 
                <option value="0">No</option>
<?php
                $sql = "SELECT module_name, student_list_hash
                        FROM $all_modules_table_name
                        WHERE access_user_id=$user_id";  
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result)) {
                    echo '<option value="'. $row['student_list_hash'] .'">'. $row['module_name'] .'</option>';
                }
?>
            </select> 
        </p>
        <p>Would you like to clone tasks from past modules? (optional)
            <select name="module_option">
                    <option value="0">No</option>  
<?php
                $sql = "SELECT module_name, module_hash
                        FROM $all_modules_table_name
                        WHERE access_user_id=$user_id";  
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result)) {
                    echo '<option value="'. $row['module_hash'] .'">'. $row['module_name'] .'</option>';
                }
?> 
            </select>  
        <p>
    <input type=submit name=submit value="Import Class List and Add New Module">
</form>

<?php
include("inc/footer.php");
?>