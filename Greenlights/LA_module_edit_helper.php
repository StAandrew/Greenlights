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
		// $sql_query = 'UPDATE '. $table .' SET '. $update_field .' WHERE id=' . $input['id'];
        $sql_query = 'INSERT INTO ' . $table . ' (id, week, session, task, task_duration, task_type) VALUES ("'. $input['id'] .'", "0", "event", "task", "0", "I") ON DUPLICATE KEY UPDATE '. $update_field;
		mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
	}
}
if ($input['action'] == 'delete') {
    $sql_query = 'DELETE FROM ' . $table . ' WHERE id=' . $input['id'];
    mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
}
mysqli_close($conn);
echo json_encode($input);