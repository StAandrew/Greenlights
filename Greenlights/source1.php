<?php include("header.php");?>
<?php include('container.php'); ?>
<?php
$connect = mysqli_connect("localhost", "root", "root", "Greenlights");

 if(isset($_POST['submit']))
    {
      $week=$_POST['week'];
      $event=$_POST['teach_event']; 
      $task=$_POST['task']; 
      $gi=$_POST['gi']; 
      $est_time=$_POST['est_time'];      
     foreach($week as $key => $value)
     {
        $sql="INSERT INTO Ratings (Week, Teaching_Event, Task, Group_Individual, Estimated_Time) 
        VALUES ('".$value."', '".$event[$key]."','".$task[$key]."','".$gi[$key]."','".$est_time[$key]."')";
         
        $sql=mysqli_query($connect,$sql);
     } 
     if ($sql=='true')
            echo "<font color=Green><b><center><h3>Data added successfully</h3></center></b></font>";
         else
             echo "<font color=Red><b><center><h3>Data could not be added. Please try again.</h3></center></b></font>";
    }
$sql = "SELECT * FROM Ratings";  
$result = mysqli_query($connect, $sql);

?>
<html>  
 <head>   
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
 </head>  
 <body>  
  <div class="container">  
   <br />  
   <br />  
   <br />  
   <div class="table-responsive">  
    <?php echo "<h2>"."<center>".$module." Greenlights Rating"."</h2>"."</center>"; ?>
 
    <table class="table table-bordered">
     <tr>  
                         <th>Week</th>  
                         <th>Teaching Event</th>  
                         <th>Task</th>  
       <th>Group or Individual</th>
       <th>Estimated Time</th>
                    </tr>
     <?php
     while($row = mysqli_fetch_array($result))  
     {  
        echo '  
       <tr>  
         <td>'.$row['Week'].'</td>  
         <td>'.$row['Teaching_Event'].'</td>  
         <td>'.$row['Task'].'</td>  
         <td>'.$row['Group_Individual'].'</td>  
         <td>'.$row['Estimated_Time'].'</td>
       </tr>  
        ';  
     }
     ?>
    </table>
    <br />
    <form method="post" action="export.php">
     <input type="submit" name="export" class="btn btn-success" value="Export" />
     <input type=button onClick="location.href='LA_Modules.php'" value='Go Back to Your Modules' class="btn btn-success">
    <a href="mailto:ta@example.com?subject=Greenlights_Rating"><input type=button name=send value="Send to TA" class="btn btn=sucess"></a>
    
    </form>
   </div>  
  </div>
<?php
include('footer.php'); ?>
 </body>  
</html>