<?php
include("inc/db_connect.php");
$table = $_GET['module'];
$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {	
	$update_field='';
	if(isset($input['week'])) {
		$update_field.= "week='".$input['week']."'";
	} else if(isset($input['session'])) {
		$update_field.= "session='".$input['session']."'";
	} else if(isset($input['task'])) {
		$update_field.= "task='".$input['task']."'";
	} else if(isset($input['task_duration'])) {
		$update_field.= "task_duration='".$input['task_duration']."'";
	} else if(isset($input['task_type'])) {
		$update_field.= "task_type='".$input['task_type']."'";
	} 
	if($update_field && $input['id']) {
		$sql = 'UPDATE '. $table .' SET '. $update_field .' WHERE id=' . $input['id'];
		mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
	}
}
else if ($input['action'] == 'delete') {
    // Safeguard to prevent deletion of last row
    $sql = 'SELECT id FROM ' . $table . ' ORDER BY id DESC LIMIT 0, 2';
    $result = $conn->query($sql);
    if ($result->num_rows > 1) {
        $sql = 'DELETE FROM ' . $table . ' WHERE id=' . $input['id'];
        mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
        
        // updates per-student tables
        $sql = "SELECT student_table_hash 
                FROM $all_students_table_name
                WHERE module_hash='$table'";
        $resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
        // for each student table
        while($row = mysqli_fetch_array($resultset)) {
            $student_table_hash = $row['student_table_hash'];
            $sql = "DELETE FROM $student_table_hash WHERE id='". $input['id'] ."'";
            if ($conn->query($sql) === TRUE) {
                echo "";
            } else {
                die ("Error: " . $conn->error);
            }
        }
    }
}
else if ($input['action'] == 'add') {
    $sql = 'SELECT id, week, session, task, task_duration, task_type FROM ' . $table . ' ORDER BY id DESC LIMIT 0, 1';
    $resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
    $result = mysqli_fetch_assoc($resultset);
    $id = (int)$result['id'] + 1;
    $week = $result['week'];
    $session = $result['session'];
    $task = $result['task'];
    $task_duration = $result['task_duration'];
    $task_type = $result['task_type'];
    $sql = 'INSERT INTO ' . $table . ' (id, week, session, task, task_duration, task_type) VALUES ("'. $id .'", "'. $week .'", "'. $session .'", "'. $task .'", "'. $task_duration .'", "'. $task_type .'")';
    mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
}
mysqli_close($conn);
echo json_encode($input);