<html>
<head>  
</head>
<body bgcolor=lightgreen>
<form name=course_entry method=post action="LR.php" enctype="multipart/form-data">
    <br>
<h1>Add Your Module</h1>
<p>
Please enter your module name here:<br>
<input type=text placeholder="Enter Module Name" name=modulename size=50>
<p>
<table>
<p>
Number of weeks:
<br>
<input type=text placeholder="Enter a number..." name=weeks size=20><p>
Please upload the relevant class list:<br>
<input type=file name=file accept=".csv">
<p>
<input type=submit name=submit value="Import Class List and Add New Module">
</form>
</body>
</html>