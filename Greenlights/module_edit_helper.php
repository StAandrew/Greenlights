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
        //$sql = 'INSERT INTO ' . $table . ' (id, week, session, task, task_duration, task_type) VALUES ("'. $input['id'] .'", "0", "event", "task", "0", "I") ON DUPLICATE KEY UPDATE '. $update_field;
		mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
	}
}
else if ($input['action'] == 'delete') {
    $sql = 'DELETE FROM ' . $table . ' WHERE id=' . $input['id'];
    mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
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