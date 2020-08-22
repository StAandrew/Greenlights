<?php
include_once("db_connect.php");
$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {	
	$update_field='';
	if(isset($input['week'])) {
		$update_field.= "week='".$input['week']."'";
	} else if(isset($input['session'])) {
		$update_field.= "session='".$input['session']."'";
	} else if(isset($input['task'])) {
		$update_field.= "task='".$input['task']."'";
	} else if(isset($input['group_number'])) {
		$update_field.= "group_number='".$input['group_number']."'";
	} else if(isset($input['rating'])) {
		$update_field.= "rating='".$input['rating']."'";
	} else if(isset($input['task_expected'])) {
		$update_field.= "task_expected='".$input['task_expected']."'";
	} else if(isset($input['task_actual'])) {
		$update_field.= "task_actual='".$input['task_actual']."'";
	} else if(isset($input['comment'])) {
		$update_field.= "comment='".$input['comment']."'";
	} else if(isset($input['action'])) {
		$update_field.= "action='".$input['action']."'";
	} else if(isset($input['meeting_date'])) {
		$update_field.= "meeting_date='".$input['meeting_date']."'";
	} else if(isset($input['meeting_duration'])) {
		$update_field.= "meeting_duration='".$input['meeting_duration']."'";
	}
	if($update_field && $input['id']) {
		$sql_query = "UPDATE TA_development.s18182839 SET $update_field WHERE id='" . $input['id'] . "'";	
		mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));		
	}
}