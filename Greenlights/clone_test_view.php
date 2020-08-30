<?php 
include_once("connect.php");
?>

<?php include("header.php");?>
    <title>Cloning Rating</title>
    <script type="text/javascript" src="dist/jquery.tabledit.js"></script>
<?php include('container.php'); ?>
    <body>
    
    <div class="container home">	
        <table id="data_table" class="table table-striped">
            <thead>
                <tr>
                 <th>ID</th>
                    <th>Week</th>
                    <th>Teaching Event</th>
                    <th>Task</th>
                    <th>Group/Individual</th>
                    <th>Estimated Time</th>
                    
                </tr>
            </thead>
            <tbody>

<?php 

$sql_query = "SELECT ID, Week, Teaching_Event, Task, Group_Individual, Estimated_Time
        FROM Ratings";
$resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
while( $row = mysqli_fetch_assoc($resultset) ) {

            print '<tr ID="' . $row['ID'] . '">';
            print '<td>' . $row['ID'] . '</td>';
            print '<td>' . $row['Week'] . '</td>';
            print '<td>' . $row['Teaching_Event'] . '</td>';
            print '<td>' . $row['Task'] . '</td>';
            print '<td>' . $row['Group_Individual'] . '</td>';
            print '<td>' . $row['Estimated_Time'] . '</td>'; 
        print '</tr>';
}
?>
            </tbody>
            </table>
            <div style="margin:50px 0px 0px 0px;">
                <a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://ucl.ac.uk">Back</a>
            </div>
        </div> 
        <script type="text/javascript" src="custom_table_edit.js"></script>
</body>
<?php
include("footer.php");
$conn->close();
?>