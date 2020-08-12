<html>
<head>
<title> 
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</title>
</head>
<body>
    <?php require_once 'process.php'; ?>
<div class="row justify-content-center">
<form action="process.php" method=POST>
<label>Session</label>
<div class="form-group">
<input type=text name=session value="Enter your Session" class="form-control">
</div>
<br>
<div class="form-group">
<label>Tasks</label><br>
<input type=text name=task value="Enter the tasks" class="form-control">
</div>
<div class="form-group">
<button type=submit name=save class="btn btn-primary">Save</button></div>
</form>
</div>
</body>
</html>