<?php  
require __DIR__ . '/db_connect.php';

$output = '';
if(isset($_POST['export_module_hash']) && isset($_POST['export_module_name'])) {
    $module_name = $_POST['export_module_name'];
    $module_hash = $_POST['export_module_hash'];
    
    $query = "SELECT * FROM $module_hash";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        $output .= '
        <table class="table" bordered="1">  
            <tr>
                <th>Week</th>
                <th>Teaching Event</th>
                <th>Task</th>
                <th>Estimated Time</th>
                <th>Group or Individual (G/I)</th>
            </tr>';
        while($row = mysqli_fetch_array($result)) {
        $output .= '
            <tr>
                <td>'.$row["week"].'</td>
                <td>'.$row["session"].'</td>
                <td>'.$row["task"].'</td>
                <td>'.$row["task_duration"].'</td>
                <td>'.$row["task_type"].'</td>
            </tr>';
        }
        $output .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='. $module_name .'.xls');
        echo $output;
    }
} else {
    echo "Error: module name and hash not set";
}
?>
