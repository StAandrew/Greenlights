<?php
include_once("connect.php");
$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {	
	$update_field='';
	if(isset($input['Week'])) {
		$update_field.= "Week='".$input['Week']."'";
	} else if(isset($input['Teaching_Event'])) {
		$update_field.= "Teaching_Event='".$input['Teaching_Event']."'";
	} else if(isset($input['Task'])) {
		$update_field.= "Task='".$input['Task']."'";
	} else if(isset($input['Group_Individual'])) {
		$update_field.= "Group_Individual='".$input['Group_Individual']."'";
	} else if(isset($input['Estimated_Time'])) {
		$update_field.= "Estimated_Time='".$input['Estimated_Time']."'";
	}
    
	if($update_field && $input['ID']) {
		$sql_query = "UPDATE Ratings SET $update_field WHERE ID='" . $input['ID'] . "'";	
		mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));		
	}
}
?>

