<?php
$connect = mysqli_connect("localhost", "root", "root", "Greenlights");
$sql = "SELECT * FROM Ratings";  
$result = mysqli_query($connect, $sql);
?>
<html>  
 <head>  
  <title>Export MySQL data to Excel in PHP</title>  
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
    <h2 align="center">Export MySQL data to Excel in PHP</h2><br /> 
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
    </form>
   </div>  
  </div>  
 </body>  
</html>