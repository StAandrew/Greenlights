<?php
include_once("inc/db_connect.php");
if ($_POST['action'] == 'edit' && $_POST['id']) {	
	$updateField='';
	if(isset($_POST['week'])) {
		$updateField.= "week='".$_POST['week']."'";
	} else if(isset($_POST['session'])) {
		$updateField.= "session='".$_POST['session']."'";
    } else if(isset($_POST['task'])) {
		$updateField.= "task='".$_POST['task']."'";
    } else if(isset($_POST['group_number'])) {
		$updateField.= "group_number='".$_POST['group_number']."'";
    } else if(isset($_POST['rating'])) {
		$updateField.= "rating='".$_POST['rating']."'";
	} else if(isset($_POST['rating'])) {
		$updateField.= "rating='".$_POST['rating']."'";
	} else if(isset($_POST['task_expected'])) {
		$updateField.= "task_expected='".$_POST['task_expected']."'";
	} else if(isset($_POST['task_actual'])) {
		$updateField.= "task_actual='".$_POST['task_actual']."'";
	} else if(isset($_POST['comment'])) {
		$updateField.= "comment='".$_POST['comment']."'";
	} else if(isset($_POST['action'])) {
		$updateField.= "action='".$_POST['action']."'";
	} else if(isset($_POST['meeting_date'])) {
		$updateField.= "meeting_date='".$_POST['meeting_date']."'";
	} else if(isset($_POST['meeting_duration'])) {
		$updateField.= "meeting_duration='".$_POST['meeting_duration']."'";
	}
	if($updateField && $_POST['id']) {
		$sqlQuery = "UPDATE s18182839 SET $updateField WHERE id='" . $_POST['id'] . "'";	
		mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));	
		$data = array(
			"messrating"	=> "Record Updated",	
			"status" => 1
		);
		echo json_encode($data);		
	}
}
if ($_POST['action'] == 'delete' && $_POST['id']) {
	$sqlQuery = "DELETE FROM s18182839 WHERE id='" . $_POST['id'] . "'";	
	mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));	
	$data = array(
		"messrating"	=> "Record Deleted",	
		"status" => 1
	);
	echo json_encode($data);	
}

