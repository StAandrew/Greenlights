<?php
include_once("inc/start_session.php");
include_once("inc/ta_check.php");
include_once("inc/db_connect.php");
include_once("inc/header.php");
?>
<h3>
	<font color=grey>Your Modules</font>
</h3>
<div style="display:inline;  text-align:center; vertical-align:middle;">
        <span style="display:table-cell; float:left; margin-left:10px; vertical-align:middle; line-height: 30px;">
<?php
    $sql = "SELECT module_name, module_hash, student_list_hash
            FROM $all_modules_table_name
            WHERE access_user_id=$user_id";  
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        echo '<h4><a href=TA_student_session_view.php?module='. $row['module_hash'] .'&student_list='. $row['student_list_hash'] .'&module_name='. $row['module_name'] .'>'. $row['module_name'] .'</a></h4>';
    }
?>
        </span>
        <span style="display:table-cell; float:left; margin-left:10px; vertical-align:middle; line-height: 30px;">
            <button>Edit module</button>
        </span>
</div>

<?php
include("inc/footer.php");
?>