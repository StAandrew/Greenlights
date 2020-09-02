<?php
include_once("inc/start_session.php");
include_once("inc/lecturer_check.php");
include_once("inc/db_connect.php");
include("inc/header.php");
?>
<h3>
	<font color=grey>Your Modules</font>
</h3>
<?php
    $sql = "SELECT module_name, module_hash, student_list_hash
            FROM $all_modules_table_name
            WHERE access_user_id=$user_id";  
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        echo '<a href=LA_module_edit.php?module='. $row['module_hash'] .'&student_list='. $row['student_list_hash'] .'>'. $row['module_name'] .'</a><br>';
    }
?>
<form name=course_entry method=post action="LA_add_module_1.php" enctype="multipart/form-data">
    <h3>
        <font color=grey>Add new module</font>
    </h3>
        <p>Please enter your module name here:<br>
            <input type=text placeholder="Enter Module Name" name=modulename size=50>
        </p>
        <p>Please upload the relevant class list:<br>
            <input type="file" name="file" id="file" accept=".csv">
        </p>
        <p>Do you want to clone from past Modules?
            <br>
            <input type=radio name=clone value=yes> Yes 
            <br>
            <input type=radio name=clone value=no checked> No   
        <p>
    <input type=submit name=submit value="Import Class List and Add New Module">
</form>

<?php
include("inc/footer.php");
?>