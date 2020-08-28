<?php
include("header.php");

// Date and time with microtime are used to prevent collisions in table names
$date = str_replace(' ', '', date("Y-m-d H:i:s").microtime());
$salt = "1F1XPkkBxcO9OmXUgSSlsExIos70CyWLirEqEWMbug8YYNLmtYz25ToVhCyZK9SuVpidelpk21RE1pTYMVPKOo6jFq7k77zJAgAC0Ce6c4BAMxj622i6MHk4VjSK0y8e";
$student_list_hash = hash('sha256', $salt.$date);

$file_name = $_FILES["class_list"]["name"];
$name = $_POST['modulename']; 
$weeks = $_POST['weeks'];
echo  "<center><h1>".$name." - ".$weeks." weeks"."</h1></center>";

function throwerror ($message) {
    $message = "Old password is wrong";
    echo "<script type='text/javascript'>alert('$message');</script>";
    header('Location: LA_modules_list.php');
    die();
}

$conn = mysqli_connect("localhost", "root", "root", "Greenlights");
if(isset($_POST["submit"])) {
    
    // Check if file exists
    if($_FILES['file']['name']) {
        
        // Check if filename is .csv
        $filename = explode(".", $_FILES['file']['name']);
        if($filename[1] == 'csv') {
            
            // Open and read file
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            
//            // TODO:
//            // validate number of rows in each column and ensure all columns are of same length
//            // validate column names as per our template. When parsing column names, make sure to convert to lower case and replace ' ' by '_'
//            $csv = array_map("str_getcsv", file("data.csv", "r")); 
//            $header = array_shift($csv); 
//            
//            foreach ($csv as $row) {      
//                $array[] = $row[$col]; 
//            }
//            
//            // Seperate the header from data
//            if(strtolower(mysqli_real_escape_string($conn, $data[0])) != "student_id" ||
//                strtolower(mysqli_real_escape_string($conn, $data[1])) != "firstname" ||
//                strtolower(mysqli_real_escape_string($conn, $data[2])) != "lastname" ||
//                strtolower(mysqli_real_escape_string($conn, $data[3])) != "email" ||
//                strtolower(mysqli_real_escape_string($conn, $data[4])) != "course_code" ||
//                strtolower(mysqli_real_escape_string($conn, $data[5])) != "year") {
//                    echo "<script>alert('Wrong table column name formating');</script>";
//            }
            
            while($data = fgetcsv($handle)) {
                $studentID = mysqli_real_escape_string($conn, $data[0]);  
                $firstname = mysqli_real_escape_string($conn, $data[1]);
                $lastname = mysqli_real_escape_string($conn, $data[2]);
                $email = mysqli_real_escape_string($conn, $data[3]);
                $course_code = mysqli_real_escape_string($conn, $data[4]);
                $year = mysqli_real_escape_string($conn, $data[5]);
                $sql  = "CREATE TABLE IF NOT EXISTS $student_list_hash (
                    student_id INT(8) UNSIGNED PRIMARY KEY,
                    firstname VARCHAR(128) NOT NULL,
                    lastname VARCHAR(128) NOT NULL,
                    email VARCHAR(128) NOT NULL,
                    course_code VARCHAR(10) NOT NULL,
                    year SMALLINT(2) NOT NULL
                )";
                if ($conn->query($sql) === FALSE) {
                    throwerror("Error creating student list table: " . $conn->error);
                }
                $sql = "INSERT INTO $student_list_hash (student_id, first_name, last_name, email, course_code, year) 
                        VALUES ('$studentID','$fname','$lname','$email','$course_code','$year')";
                if ($conn->query($sql) === FALSE) {
                    throwerror("Error inserting into student list table: " . $conn->error);
                }
            }
            fclose($handle);
            echo "<script>alert('Class List Successfully Imported');</script>";
        } else {
            throwerror ("Error! Wrong file format');</script>");
        }
    } else {
        throwerror ("Error! Failed to open file");
    }
}
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
                    <th>Add/Remove a Row</th>
                </tr>
    <?php

    $conn=mysqli_connect("localhost","root","root","Greenlights");
        
    if(isset($_POST['submit'])) {
        $week=$_POST['week'];
        $event=$_POST['teach_event']; 
        $task=$_POST['task']; 
        $gi=$_POST['gi']; 
        $est_time=$_POST['est_time'];      
        foreach($week as $key => $value) {
            $sql="INSERT INTO Ratings (Week, Teaching_Event, Task, Group_Individual, Estimated_Time) 
                    VALUES ('".$value."', '".$event[$key]."','".$task[$key]."','".$gi[$key]."','".$est_time[$key]."')";
            $sql=mysqli_query($conn,$sql);
            if ($sql=='true') {
                echo "<font color=Green><b><center><h3>Data added successfully</h3></center></b></font>";
            }
            else {
             echo "<font color=Red><b><center><h3>Data could not be added. Please try again.</h3></center></b></font>";
            }
        }    
    }
?>
        
        
                <tr>
                    <td><input class="form-control" type=text name=week[] required></td>     
                    <td><input class="form-control" type=text name=teach_event[]  required></td>
                    <td><input class="form-control" type=text name=task[]  required length=50 ></td>  
                    <td><input class="form-control" type=text name=gi[]  required></td>  
                    <td><input class="form-control" type=text name=est_time[]  required></td> 
                    <td><input class="btn btn-warning" type=button name=add id=add value=Add></td>
                </tr>
            </table>
            <center>
                <input class="btn btn-success" type=submit name=submit id="submit" value=Submit> 
                <br>
                <br>
                <br>
                <input class="btn btn-success" type=button name=download id="download" value="Download Rating Table">
            </center>
        </div> 
    </form>
    <table class="table table-striped">
        <tr>
            <th>Week</th>
            <th>Teaching Event</th>
            <th>Task</th>
            <th>Group/Individual</th>
            <th>Estimated Time for task</th>
        </tr>
<?php
$select="SELECT * FROM Ratings";
$result=mysqli_query($conn,$select);
while ($row = mysqli_fetch_array($result)) {
?>
        <tr>
            <td> <?php echo $row['Week']; ?> </td>
            <td> <?php echo $row['Teaching_Event']; ?> </td>
            <td> <?php echo $row['Task']; ?> </td>
            <td> <?php echo $row['Group_Individual']; ?> </td>
            <td> <?php echo $row['Estimated_Time']; ?> </td>   
        </tr>  
     
<?php    
}     
?>
    </table>  
</div>

<?php  
//export.php  
$conn = mysqli_connect("localhost", "root", "root", "Greenlights");
$output = '';
if(isset($_POST['download'])) {
    $query = "SELECT * FROM Ratings";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        $output .= '<table class="table" bordered="1">  
                        <tr>  
                            <th>Week</th>  
                            <th>Teaching Event</th>  
                            <th>Task</th>  
                            <th>Group or Individual</th>
                            <th>Estimated Time</th>
                        </tr>';
        while($row = mysqli_fetch_array($result)) {
            $output .= '<tr>  
                            <td>'.$row["Week"].'</td>  
                            <td>'.$row["Teaching_Event"].'</td>  
                            <td>'.$row["Task"].'</td>  
                            <td>'.$row["Group_Individual"].'</td>  
                            <td>'.$row["Estimated_Time"].'</td>
                        </tr>';
        }
        $output .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=rating.xls');
        echo $output;
    }
}
?>

<script 
        type="text/javascript" 
        src="LA_custom_table_edit.js">
</script>

<?php
include("footer.php");
?>