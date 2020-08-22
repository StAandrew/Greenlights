<html>
<head>
<title> 
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </title></head>
<body>
    <?php require_once 'Process.php'; ?>
    <div class="container">
<?php
$mysqli= new mysqli ("localhost","root","root","Greenlights");    
$result=$mysqli->query("Select * from Course"); 
//pre_r($result); 
?>
  <div class="row justify-content-center">
        <table  class=table>
        <thead>
         <tr>
            <th>Session</th>
            <th>Task </th>
            <th colspan="2">Action</th>
            </tr>   
            </thead>
            
            <?php
            while ($row=$result->fetch_assoc()):    ?>
            <tr>
            <td> <?php echo $row['Session']; ?> </td>
            <td> <?php echo $row['Task']; ?> </td>    
            <td> 
                <a href="CRUD.php?edit=<?php echo $row['ID']; ?>" class="btn btn-info">Edit</a>
                <a href="Process.php?delete=<?php echo $row['ID'];?>" class="btn btn-danger">Delete</a> 
                </td>   
            </tr>
            <?php endwhile; ?> 
           </table>
    </div>    
     
<?php
function pre_r($array)
{
 echo '<pre>';
 print_r($array);
 echo '</pre>';
}
?> 
    
<div class="row justify-content-center">
<form action="Process.php" method=POST>
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
<button type=submit name=save class="bt btn-primary">Save</button></div>
</form>
</div>
</div>
</body>
</html>