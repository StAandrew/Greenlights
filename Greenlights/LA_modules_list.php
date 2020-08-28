<?php
include("header.php");
if($_SESSION['user_type'] == "Lecturer") {
    
} else {
    // Redirect to login
    if (isset($_SESSION['base_url']))
        header('Location: login.php');
    else
        echo "Please log in";
}
?>
<form name=course_entry method=post action="Lecturer_Rating.php" enctype="multipart/form-data">
    <h3>Add new module</h3>
        <p>Please enter your module name here:<br>
            <input type=text placeholder="Enter Module Name" name=modulename size=50>
        </p>
        <p>Number of weeks:<br>
            <input type=text placeholder="Enter a number..." name=weeks size=20>
        </p>
        <p>Please upload the relevant class list:<br>
            <input type=file name=file accept=".csv">
        </p>
    <input type=submit name=submit value="Import Class List and Add New Module">
</form>

<?php
include("footer.php");
?>