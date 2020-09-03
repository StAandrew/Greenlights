<?php
include_once("inc/db_connect.php");
$table = $_GET['table'];
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
        if($input['group_number'] == null || $input['group_number'] == 0 || $input['group_number'] == ' ')
            $input['group_number'] = 0;
		$update_field.= "group_number='".$input['group_number']."'";
	} else if(isset($input['rating'])) {
        if($input['rating'] == 'G' || $input['rating'] == 'g' || $input['rating'] == 'green')
            $input['rating'] = 'Green';
        else if($input['rating'] == 'A' || $input['rating'] == 'a' || $input['rating'] == 'amber')
            $input['rating'] = 'Amber';
        else if($input['rating'] == 'R' || $input['rating'] == 'r' || $input['rating'] == 'red')
            $input['rating'] = 'Red';
		$update_field.= "rating='".$input['rating']."'";
	} else if(isset($input['task_duration'])) {
		$update_field.= "task_duration='".$input['task_duration']."'";
	} else if(isset($input['task_type'])) {
		$update_field.= "task_type='".$input['task_type']."'";
	} else if(isset($input['task_actual'])) {
		$update_field.= "task_actual='".$input['task_actual']."'";
	} else if(isset($input['comment'])) {
		$update_field.= "comment='".$input['comment']."'";
	} else if(isset($input['actions'])) {
		$update_field.= "actions='".$input['actions']."'";
	} else if(isset($input['meeting_date'])) {
		$update_field.= "meeting_date='".$input['meeting_date']."'";
	} else if(isset($input['meeting_duration'])) {
		$update_field.= "meeting_duration='".$input['meeting_duration']."'";
	}
	if($update_field && $input['id']) {
		$sql_query = 'UPDATE ' . $table . ' SET ' . $update_field . 'WHERE id=' . $input['id'];
		mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
	}
}