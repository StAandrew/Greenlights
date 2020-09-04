<?php
include_once("inc/enable_debug.php");

include_once("inc/start_session.php");
include_once("inc/lecturer_check.php");
include_once("inc/db_connect.php");
include("inc/header.php");


// TODO: pass module name as get argument
// Get hash - table name
if (isset($_GET['module_name']) && isset($_GET['module']) && isset($_GET['student_list'])) {
    $module_name = $_GET['module_name'];
    $module_hash = $_GET['module'];
    $student_list_hash = $_GET['student_list'];
} else {
    echo "Error: get arguments was not found";
    die();
}

?>     
    <div id="js-helper"
         data-module-id="<?php echo htmlspecialchars($module_hash); ?>">
    </div>
    <h3>
        <font color=grey><?php echo $module_name; ?></font>
    </h3>
    <div id="table_view">	
        <table id="data_table" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Week</th>
                    <th>Teaching event</th>
                    <th>Task</th>
                    <th>Task duration (minutes)</th>
                    <th>Task type</th>
                </tr>
            </thead>
            <tbody>
<?php
$sql = "SELECT num, week, session, task, task_duration, task_type
        FROM $module_hash";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
while( $row = mysqli_fetch_assoc($resultset) ) {
        print '<tr id="' . $row['num'] . '">';
            print '<td>' . $row['num'] . '</td>';
            print '<td>' . $row['week'] . '</td>';
            print '<td>' . $row['session'] . '</td>';
            print '<td>' . $row['task'] . '</td>';
            print '<td>' . $row['task_duration'] . '</td>';
            print '<td>' . $row['task_type'] . '</td>'; 
        print '</tr>';
}
?>
            </tbody>
        </table>
    </div>
    <div>
        <h3>
	       <font color=grey>Access edit</font>
        </h3>
        
        <div style="width:50%">
            <table class="table" style="border:solid lightgrey 0.5px;">
                <thead>
                    <tr>
                        <th>Full name</th>
                        <th>Email</th>
                        <th>User type</th>
                        <th>User id</th>
                    </tr>
                </thead>
                <tbody>
<?php
        $sql = "SELECT num, access_user_id, access_user_type
        FROM $all_modules_table_name
        WHERE module_hash='$module_hash'";
        $resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
        while( $row = mysqli_fetch_assoc($resultset) ) {
            print '<tr id="' . $row['num'] . '">';
                //print '<td>' . $row['num'] . '</td>';
                print '<td>Name Surname</td>';
                print '<td>Email</td>';
                print '<td>' . $row['access_user_type'] . '</td>';
                print '<td>' . $row['access_user_id'] . '</td>';
            print '</tr>';
        }
?>
                </tbody>
            </table>
        </div>
        <font color=grey>Add new:</font>
        <select>  
            <option value="Select">Select</option>  
            <option value="Vineet">Vineet Saini, TA, 100000001</option>  
            <option value="Sumit">Sumit Sharma, TA, 100000003</option>  
            <option value="Dorilal">Dorilal Agarwal, TA, 100000002</option>  
            <option value="Omveer">Omveer Singh, TA, 100000006</option>  
            <option value="Rohtash">Rohtash Kumar, TA, 100000005</option>  
            <option value="Maneesh">Maneesh Tewatia, Lecturer, 100000008</option>  
            <option value="Priyanka">Priyanka Sachan, Lecturer, 100000004</option>  
            <option value="Neha">Neha Saini</option>  
        </select>   
<!--        <button>Add</button>-->
        
        <div style="margin:50px 0px 0px 0px;">
            <a class="btn btn-default read-more" style="background:#3399ff;color:white" href="./LA_modules_list.php">Save changes</a>
        </div>
    </div>
    <script 
            type="text/javascript" 
            src="js/LA_module_edit_table_edit.js">
    </script>

<?php

// Add add TA function, save to $all_modules_table_name
// when pressed save, fetch all tables from $all_students_table_name, and update all of them

include("inc/footer.php");
?>