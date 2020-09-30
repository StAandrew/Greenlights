<?php  
require __DIR__ . '/db_connect.php';

$output = '';
if(isset($_POST['export_module_hash']) && isset($_POST['export_module_name'])) {
    $module_name = $_POST['export_module_name'];
    $module_hash = $_POST['export_module_hash'];
    $date = date('Y-m-d');
    
    $sql = "SELECT * FROM $module_hash";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        $output .= 'Week;Teaching Event;Task;Estimated Time;Group or Individual(G/I)'. PHP_EOL;
        while($row = mysqli_fetch_array($result)) {
        $row['session'] = str_replace(';', ',', $row['session']);
        $row['task'] = str_replace(';', ',', $row['task']);
        
        $output .= $row["week"] .';'. $row["session"] .';'. $row["task"] .';'. $row["task_duration"] .';'. $row["task_type"] . PHP_EOL;
        }
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='. $module_name .'_'. $date .'.csv');
        echo $output;
    } else {
        echo "Error: cannot connect to a database";
    }
} else {
    echo "Error: module name and hash not set";
}
?>
