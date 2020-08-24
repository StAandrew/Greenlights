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

<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


<script  src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
<script src="bootstable.min.js"></script>  



<div style="width:70%; margin: auto;">
</head>
<body>
<table class="table" id="makeEditable">
    <thead>
      <tr>
        <th>Week</th>
        <th>Teaching Event</th>
        <th>Task </th>
        <th>Group/Individual (G/I)</th>
        <th> Estimted Time for the Task</th>
        <th> Actual Time Taken
        <span style="float:right"><button id="but_add">Add New Row</button></span></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Week Number</td>
        <td>Name of Teaching Event></td>
        <td>Description of Task and Rating</td>
        <td>Please spceify group/individual</td>
        <td> Please specify the estimted time for the task</td>
        <td> Please fill in the actual time taken</td>
      </tr>          
    </tbody>
  </table>
</div>
<script>
 $('#makeEditable').SetEditable({ $addButton: $('#but_add')});
</script> 
</body>
</html>




