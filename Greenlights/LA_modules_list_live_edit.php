<?php
include_once("inc/db_connect.php");
$module = $_GET['module'];
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
		$sql_query = "UPDATE TA_development." . $module . " SET $update_field WHERE num='" . $input['id'] . "'";
		mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
	}
}