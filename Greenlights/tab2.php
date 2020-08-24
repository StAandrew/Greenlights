<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script type=text/javascript>
    $(document).ready(function(){
var html='<tr><td><input type=text name=week[]  required>  </td><td><input type=text name=teach_event[]  required> </td> <td><input type=text name=task[]  required> </td><td><input type=text name=gi[]  required>  </td><td><input type=text name=est_time[]  required>  </td><td><input type=text name=act_time[]  required></td><td><input type=button name=remove id=remove value=remove class="btn btn-danger"></td></tr>';  
        
var max=5
        var x=1;
       
        
$("#add").click(function(){
    $("#table_field").append(html);

 }); 
        
$("#table_field").on('click','#remove',function(){
    $(this).closest('tr').remove();

});
});
</script>   
    
    
    
</head>
<body>
<?php 
$file_name=$_FILES["class_list"]["name"];
$name=$_POST['modulename']; 
$weeks=$_POST['weeks'];
echo  "<center>"."<h1>".$name." - ".$weeks." weeks"."</h1>"."</center>";
    
$connect = mysqli_connect("localhost", "root", "root", "Greenlights");
if(isset($_POST["submit"]))
{
 if($_FILES['file']['name'])
 {
  $filename = explode(".", $_FILES['file']['name']);
  if($filename[1] == 'csv')
  {
   $handle = fopen($_FILES['file']['tmp_name'], "r");
   while($data = fgetcsv($handle))
   {
    $studentID = mysqli_real_escape_string($connect, $data[0]);  
    $fname = mysqli_real_escape_string($connect, $data[1]);
    $lname = mysqli_real_escape_string($connect, $data[2]);
    $email = mysqli_real_escape_string($connect, $data[3]);
    $course_reg = mysqli_real_escape_string($connect, $data[4]);
    $course_year = mysqli_real_escape_string($connect, $data[5]);
    $query = "INSERT into classlist(student_id, first_name, last_name, email, course_registration, course_year) values('$studentID','$fname','$lname','$email','$course_reg','$course_year')";
    mysqli_query($connect, $query);
   }
   fclose($handle);
   echo "<script>alert('Class List Successfully Imported');</script>";
  }
 }
}
?>  
?>
<div class=container>
<form class="insert-form" id="insert_form" method=post action="<?php echo $_SERVER['PHP_SELF']; ?>">
<hr>
<h1>Testing</h1>
    <hr>
    <div class="input-field">
    <table class="table table-bordered" id="table_field">
    <tr>
    <th>Week</th>
    <th>Teaching Event</th>
    <th>Task</th>
        <th>Group/Individual</th>
    <th>Estimated Time for task</th>
    <th>Actual Time Taken</th>
    <th>Add or Remove</th>
    </tr>
    <?php
    $conn=mysqli_connect("localhost","root","root","Greenlights");
        
    if(isset($_POST['submit']))
    {
      $week=$_POST['week'];
      $event=$_POST['teach_event']; 
      $task=$_POST['task']; 
      $gi=$_POST['gi']; 
      $est_time=$_POST['est_time']; 
      $act_time=$_POST['act_time']; 
        
     foreach($week as $key => $value)
     {
        $sql="INSERT INTO Rating (Week, Teaching_Event, Task, Group_Individual, Estimated_Time, Actual_Time) 
        VALUES ('".$value."', '".$event[$key]."','".$task[$key]."','".$gi[$key]."','".$est_time[$key]."','".$act_time[$key]."')";
         
        $sql=mysqli_query($conn,$sql);
        if ($sql=='true')
            echo "<font color=Green><b><center><h3>Data added successfully</h3></center></b></font>";
         
     }
       
    }


?>
        
        
    <tr>
        <td><input class="form-control" type=text name=week[] required>  </td>     
        <td><input class="form-control" type=text name=teach_event[]  required> </td> <td><input class="form-control" type=text name=task[]  required length=50 > </td>  
        <td><input class="form-control" type=text name=gi[]  required>  </td>  
        <td><input class="form-control" type=text name=est_time[]  required>  </td> 
        <td><input class="form-control" type=text name=act_time[]  required>  </td> 
        <td><input class="btn btn-warning" type=button name=add id=add value=Add>  </td></tr>
        
        
        </table>
    <center>
        <input class="btn btn-success" type=submit name=submit id="submit"
       value=Submit> 
        </center>
    
    </div>
    
    
    
    
    
    </form>
    </div>
</body>
</html>