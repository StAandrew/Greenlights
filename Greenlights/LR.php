<?php 
include_once("enable_debug.php");

include_once("start_session.php");
include_once("lecturer_check.php");
include_once("db_connect.php");
include("header.php");

// Get module name
if (isset($_POST['modulename'])) {
    $name = $_POST['modulename']; 
} else
    die("No module name");

// Generate a hash of the table for the module
$to_hash = str_replace('.', '', str_replace(':', '', str_replace('-', '', str_replace(' ', '', date("Y-m-d H:i:s").microtime())))); //get accurate date
$to_hash .= "studentstable";
$to_hash .= $user_id; //add lecturer's id
$student_list_hash = hash('sha256', $to_hash);

// Create student table named by student hash
$sql = "CREATE TABLE $student_list_hash (
    student_id INT(8) UNSIGNED PRIMARY KEY,
    firstname VARCHAR(128) NOT NULL,
    lastname VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    course_code VARCHAR(10) NOT NULL,
    year SMALLINT(2) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    $success = true;
} else {
    die ("Error creating table: " . $conn->error);
    $success = false;
}
    
// Populate student table with data from file
if(isset($_POST["submit"])) {
    if (isset($_FILES["file"])) {
        // Check for errors
        if ($_FILES["file"]["error"] > 0) {
            echo "There was an error uploading the file. Return Code: " . $_FILES["file"]["error"] . "<br />";
            die();
        }
        // Check if file already uploaded
        if (file_exists("upload/" . $_FILES["file"]["name"])) {
            echo $_FILES["file"]["name"] . " already exists. ";
            die();
        }
        
        if($_FILES['file']['name']) {
            $filename = explode(".", $_FILES['file']['name']);
            if($filename[1] == 'csv') {
                $temp = $_FILES["file"]["tmp_name"];
                $file = new SplFileObject($temp);
                $file->setFlags(SplFileObject::READ_CSV);
                $csv = new LimitIterator($file, 1); // Skips first row
                
                foreach ($csv as $row) {
                    $data = explode(";", $row[0]);
                    
                    $studentID = $data[0]; 
                    $firstname = $data[1];
                    $lastname = $data[2];
                    $email = $data[3];
                    $course_code = $data[4];
                    $course_year = $data[5];

                    $sql = "INSERT INTO $student_list_hash (student_id, firstname, lastname, email, course_code, year) VALUES ('$studentID','$firstname','$lastname','$email','$course_code','$course_year')";
                    if ($conn->query($sql) === TRUE) {
                        $success = true;
                    } else {
                        die ("Error creating table: " . $conn->error);
                        $success = false;
                    }
                }
                if (!$success)
                    throwError("Failed to save to file", $student_list_hash);
            } else {
                throwError("Filename not .csv", $student_list_hash);
            }
        } else {
            throwError("File not found", $student_list_hash);
        }
    } else {
        throwError("FILES is not set", $student_list_hash);
    }
} else {
    throwError("No submit in POST", $student_list_hash);
}

// Function to throw error if there is a problem with students table
function throwError ($message, $hash) {
    include_once("db_connect.php");
    echo 'Error: '. $message;
    $sql = "DROP TABLE IF EXISTS $hash";
    $conn->query($sql);
    $_POST = array();
    die();
}
?>
<form class="insert_form" id="insert_form" method=post action="source1.php">
    <hr>
    <h1>
        <?php echo $name;?>
    </h1>
    <hr>
    <div class="input-field">
        <table class="table table-bordered" id="table_field">
            <tr>
                <th>Week number</th>
                <th>Teaching Event</th>
                <th>Task</th>
                <th>Group or Individual (G/I)</th>
                <th>Estimated time for a task (minutes)</th>
                <th>Add/Remove row</th>
            </tr>
            <tr>
                <input type='hidden' name='module_name' value='<?php echo $_POST['modulename'];?>' />
                <input type='hidden' name='student_list_hash' value='<?php echo $student_list_hash;?>' />
                <td><input class="form-control" type=text name=week[] required>  </td>     
                <td><input class="form-control" type=text name=session[]  required> </td> 
                <td><input class="form-control" type=text name=task[]  required length=50 > </td>  
                <td><input class="form-control" type=text name=task_type[]  required>  </td>  
                <td><input class="form-control" type=text name=task_duration[]  required>  </td> 
                <td><input class="btn btn-warning" type=button name=add id=add value=Add>  </td>
            </tr>
        </table>
        <center>
            <input class="btn btn-success" type=submit name=submit id="submit" value=Submit> 
        </center>
    </div> 
</form>  
<script 
    type="text/javascript" 
    src="LA_custom_table_edit.js">
</script>
<?php
    include("footer.php");
?>