<?php  
//export.php  
$connect = mysqli_connect("localhost", "root", "root", "Greenlights");
$output = '';
if(isset($_POST['export']))
{
 $query = "SELECT * FROM Ratings";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Week</th>  
                         <th>Teaching Event</th>  
                         <th>Task</th>  
       <th>Group or Individual</th>
       <th>Estimated Time</th>
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>'.$row["Week"].'</td>  
                         <td>'.$row["Teaching_Event"].'</td>  
                         <td>'.$row["Task"].'</td>  
       <td>'.$row["Group_Individual"].'</td>  
       <td>'.$row["Estimated_Time"].'</td>
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=rating.xls');
  echo $output;
 }
}
?>
