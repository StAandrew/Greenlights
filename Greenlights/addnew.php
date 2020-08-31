<html>
<head>  
</head>
<body>
<?php include("header.php");?>
<?php include('container.php'); ?>
<form name=course_entry method=post action="LR.php" enctype="multipart/form-data">
    <br>
<h1>Add Your Module</h1>
<p>
<b>Please enter your module name here:</b><p>
<input type=text placeholder="Enter Module Name" name=modulename size=50>
<p> <br>
<p>
<p>
<b>Number of weeks:</b>
<br>
<p>
<input type=text placeholder="Enter a number..." name=weeks size=20><p> <br>
<b>Please upload the relevant class list:</b><br><br>
<input type=file name=file accept=".csv">
<p><br>
<b>Do you want to clone a Rating List that you have already created?</b>
<br>
<input type=radio name=clone value=yes> Yes
<br>
<p>
<input type=radio name=clone value=no> No   
<p>
<p>
<input type=submit name=submit value="Import Class List and Add New Module">
</form>
<?php
include('footer.php'); ?>
</body>
</html>