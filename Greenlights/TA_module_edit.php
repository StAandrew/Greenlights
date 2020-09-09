<?php
include_once("inc/enable_debug.php");

include_once("inc/start_session.php");
include_once("inc/ta_check.php");
include_once("inc/db_connect.php");
include("inc/header.php");

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
    <div style="margin:10px 0px 0px 0px;">
        <font color=grey>Please make sure to save changes before leaving the page:</font>
        <form action="./TA_modules_list.php" method="post">
            <input type="hidden" name="module_hash_to_save" value="<?php echo $module_hash; ?>"/>
            <input type="submit" value="Save changes" class="btn btn-default read-more" style="background:#3399ff;color:white"/>
        </form>
    </div>
    <div style="margin:50px 0px 0px 0px;">
        <form action="./export_csv.php" method="post">
            <input type='hidden' name='export_module_name' value='<?php echo $module_name;?>' />
            <input type='hidden' name='export_module_hash' value='<?php echo $module_hash;?>' />
            <input type="submit" name="export_module" value="Save module as .csv file"/>
        </form>
        <form action="./export_xls.php" method="post">
            <input type='hidden' name='export_module_name' value='<?php echo $module_name;?>' />
            <input type='hidden' name='export_module_hash' value='<?php echo $module_hash;?>' />
            <input type="submit" name="export_module" value="Save module as .xls file"/>
        </form>
    </div>
    <script 
            type="text/javascript" 
            src="js/LA_module_edit_table_edit.js">
    </script>

<?php
include("inc/footer.php");
?>