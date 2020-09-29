<?php
include("inc/db_connect.php");
include("system/variables.php");
$table = $_GET['module'];
$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'delete') {
    $delete_module_hash = $input['id'];
    
    $sql = 'SELECT id FROM ' . $table . ' ORDER BY id DESC LIMIT 0, 2';
    $result = $conn->query($sql);
    if ($result->num_rows > 1) {
        $sql = 'DELETE FROM ' . $table . ' WHERE id=' . $input['id'];
        mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
    }
    
    // Drop table of a module
    $sql = "DROP TABLE IF EXISTS $delete_module_hash";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Failed to delete table $delete_module_hash";
    }
    
    // Delete records from all modules table
    $sql = "DELETE FROM $all_modules_table_name WHERE module_hash='$delete_module_hash'";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Failed to delete from all modules table";
    }
    
    // Drop per-student tables
    $sql = "SELECT student_table_hash, module_hash FROM $all_students_table_name WHERE module_hash='$delete_module_hash'";
    $resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
    while($row = mysqli_fetch_array($resultset)) {
        $delete_student_table = $row['student_table_hash'];
        $sql = "DROP TABLE IF EXISTS $delete_student_table";
        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Failed to delete students table $delete_student_table";
        }
    }
    
    // Delete records from all student table
    $sql = "DELETE FROM $all_students_table_name WHERE module_hash='$delete_module_hash'";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Failed to delete from all modules table";
    }
    
    // Check if student list is still being used by other modules
    $student_list_used = false;
    $sql = "SELECT student_list_hash, module_hash FROM $all_modules_table_name WHERE module_hash='$delete_module_hash'";
    $resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
    while($row = mysqli_fetch_array($resultset)) {
        $student_list_used = true;
    }
    if (!$student_list_used) {
        $sql = "DROP TABLE IF EXISTS $delete_student_list";
        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Failed to delete table $delete_student_list";
        }
    }    
}
mysqli_close($conn);
echo json_encode($input);