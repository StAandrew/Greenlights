<?php
include_once("start_session.php");
if(isset($_SESSION['user_type']) && isset($_SESSION['login_url'])) {
    if($_SESSION['user_type'] != "Lecturer") {
            exit(header('Location: ' . $_SESSION['login_url']));
    }
} else {
    include("header.php");
    echo "Please log in";
    die();
}
include("header.php");
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
        <p>Do you want to clone a Rating List that you have already created?
            <br>
            <input type=radio name=clone value=yes> Yes 
            <br>
            <input type=radio name=clone value=no checked> No   
        <p>
    <input type=submit name=submit value="Import Class List and Add New Module">
</form>

<?php
include("footer.php");
?>