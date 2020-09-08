<?php  
include_once("inc/db_connect.php");

$output = '';
if(isset($_POST['export_module_hash']) && isset($_POST['export_module_name'])) {
    $module_name = $_POST['export_module_name'];
    $module_hash = $_POST['export_module_hash'];
    
    $query = "SELECT num, week, session, task, task_duration, task_type FROM $module_hash";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        $output .= 'Week,Teaching Event,Task,Estimated Time,Group or Individual (G/I)'.PHP_EOL;
        while($row = mysqli_fetch_array($result)) {
        $output .= $row["week"].','.$row["session"].','.$row["task"].','.$row["task_duration"].','.$row["task_type"].PHP_EOL;
        }
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='. $module_name .'.csv');
        echo $output;
    }
} else {
    echo "Error: module name and hash not set";
}
?>
