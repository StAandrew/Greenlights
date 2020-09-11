<?php 
include_once("inc/enable_debug.php");

include_once("inc/start_session.php");
include_once("inc/lecturer_check.php");
include_once("inc/db_connect.php");
include("inc/header.php");

if(isset($_POST["submit"]) && isset($_POST['student_list_option']) && isset($_POST['module_option'])) {
    echo "";
} else {
    echo "Please return to previous page";
    die();
}

// Get module name
if (isset($_POST['module_name'])) {
    $module_name = $_POST['module_name']; 
} else
    die("No module name");

// STUDENT LIST AREA
// If student list clone option was selected
if ($_POST['student_list_option'] != '0') {
    $student_list_hash = $_POST['student_list_option'];
}
// Populate student table with data from file
else if (isset($_FILES["file"])) {
    // Check for errors
    if ($_FILES["file"]["error"] > 0) {
        echo "Please upload a file. <br/>Return Code: " . $_FILES["file"]["error"] . "<br/>";
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
            
            // Generate a hash of the table for the module
            $to_hash = str_replace('.', '', str_replace(':', '', str_replace('-', '', str_replace(' ', '', date("Y-m-d H:i:s").microtime())))); //get accurate date
            $to_hash .= "studentstable";
            $to_hash .= $user_id; //add lecturer's id
            $student_list_hash = hash('sha256', $to_hash);
            $student_list_hash = substr($student_list_hash, 1);
            $student_list_hash = "l" . $student_list_hash;

            // Create student table named by student hash
            $sql = "CREATE TABLE $student_list_hash (
                student_id INT(9) UNSIGNED PRIMARY KEY,
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
            
            // For each csv row
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
            throwError("Filename not .csv", "");
        }
    } else {
        throwError("File not found", "");
    }
} else {
    throwError("FILES is not set", "");
}
// Function to throw error if there is a problem with students table
function throwError ($message, $hash) {
    if ($hash == "") {
        echo 'Error: '. $message;
    } else {
        include_once("inc/db_connect.php");
        echo 'Error: '. $message;
        $sql = "DROP TABLE IF EXISTS $hash";
        $conn->query($sql);
    }
    $_POST = array();
    die();
}


// TASKS AREA
// Get options for cloning tasks
if ($_POST['module_option'] != '0') {
    $module_hash = $_POST['module_option'];
    $_POST = array();
?>
<form name='fr' action='LA_add_module_2.php' method='POST'>
    <input type='hidden' name='module_name' value='<?php echo $module_name; ?>'/>
    <input type='hidden' name='student_list_hash' value='<?php echo $student_list_hash; ?>'/>
    <input type='hidden' name='module_hash' value='<?php echo $module_hash; ?>'/>
</form>
<script type='text/javascript'>
    document.fr.submit();
</script>
<?php
die();
// Allow user to insert options
} else {
	// Generate a hash of the table for the module
	$to_hash = str_replace('.', '', str_replace(':', '', str_replace('-', '', str_replace(' ', '', date("Y-m-d H:i:s").microtime())))); 	//get accurate date
	$to_hash .= "moduletable";
	$to_hash .= preg_replace('/\s+/', '_', $module_name); //replace spaces by underscores
	$to_hash .= $user_id; //add lecturer's id
	$module_table_hash = hash('sha256', $to_hash);
	$module_table_hash = substr($module_table_hash, 1);
	$module_table_hash = "m" . $module_table_hash;

	// Create table
	$sql = "CREATE TABLE $module_table_hash (
	        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	        week SMALLINT(2) UNSIGNED NOT NULL,
	        session VARCHAR(128) NOT NULL,
	        task VARCHAR(256) NOT NULL,
	        task_duration SMALLINT(4) NOT NULL,
	        task_type VARCHAR(1) DEFAULT 'I'
	)";
	if ($conn->query($sql) === TRUE) {
	    echo "";
	} else {
	    throwError("Error creating table: $conn->error", $module_table_hash);
	}
    
    // Insert one row
    $week = "0";
    $session = "event";
    $task = "task";
    $task_duration = "0";
    $task_type = "I";
        
    $sql = "INSERT INTO $module_table_hash (week, session, task, task_duration, task_type) VALUES ('$week', '$session', '$task', '$task_duration', '$task_type')";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        throwError("Error creating table: $conn->error", $module_table_hash);
    }
	
?>
    <hr>
    <h1>
        <?php echo $module_name;?>
    </h1>
    <hr>
    <div id="js-helper"
         data-module-id="<?php echo htmlspecialchars($module_table_hash); ?>">
    </div>
    <div id="table_view" class="input-field">
        <table id="data_table" class="table table-striped">
			<thead>
            	<tr>
					<th>Unique id</th>
                	<th>Week number</th>
                	<th>Teaching Event</th>
                	<th>Task</th>
                	<th>Estimated time for a task (minutes)</th>
                	<th>Group or Individual (G/I)</th>
                	<th>Add/Remove row</th>
            	</tr>
			</thead>
			<tbody>
<?php
	$sql = "SELECT id, week, session, task, task_duration, task_type FROM $module_table_hash";
    $resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
    while( $row = mysqli_fetch_assoc($resultset) ) {
        print '<tr id="' . $row['id'] . '">';
            print '<td>' . $row['id'] . '</td>';
            print '<td>' . $row['week'] . '</td>';
            print '<td>' . $row['session'] . '</td>';
            print '<td>' . $row['task'] . '</td>';
            print '<td>' . $row['task_duration'] . '</td>';
            print '<td>' . $row['task_type'] . '</td>';
            print "<td><button id='add' for-table='#data_table'>Add Row</button></td>";
        print '</tr>';
    }
?>
			</tbody>
        </table>
    </div> 
<form class="insert_form" id="insert_form" method=post action="LA_add_module_2.php">
    <input type='hidden' name='module_name' value='<?php echo $_POST['module_name'];?>' />
    <input type='hidden' name='module_table_hash' value='<?php echo $module_table_hash?>' />
    <input type='hidden' name='student_list_hash' value='<?php echo $student_list_hash;?>' />
        <center>
            <input class="btn btn-success" type=submit name=cancel id="cancel" value=Cancel> 
            <input class="btn btn-success" type=submit name=submit id="submit" value=Submit> 
        </center>
</form>  
<script 
    type="text/javascript" 
    src="js/LA_custom_table_edit.js">
</script>
<?php
}
    include("inc/footer.php");
?>