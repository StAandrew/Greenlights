<?php
include_once("inc/enable_debug.php");

include_once("inc/start_session.php");
include_once("inc/lecturer_check.php");
include_once("inc/db_connect.php");
include("inc/header.php");

// Get module name and number of weeks and students table hash
if (isset($_POST['module_name']) && isset($_POST['student_list_hash'])) {
    $module_name = $_POST['module_name'];
    $student_list_hash = $_POST['student_list_hash'];
} else {
    die ("POST error: module name not found");
}

// Generate a hash of the table for the module
$to_hash = str_replace('.', '', str_replace(':', '', str_replace('-', '', str_replace(' ', '', date("Y-m-d H:i:s").microtime())))); //get accurate date
$to_hash .= "moduletable";
$to_hash .= preg_replace('/\s+/', '_', $module_name); //replace spaces by underscores
$to_hash .= $user_id; //add lecturer's id
$module_table_hash = hash('sha256', $to_hash);
$module_table_hash = substr($module_table_hash, 1);
$module_table_hash = "m" . $module_table_hash;

// Save to main table (all modules table)
$sql = "INSERT INTO $all_modules_table_name (module_name, module_hash, access_user_id, access_user_type, student_list_hash) 
        VALUES ('$module_name', '$module_table_hash', '$user_id', 'Lecturer', '$student_list_hash')";     
if ($conn->query($sql) === TRUE) {
    echo "";
} else {
    throwErrorQuit("Error adding data to main table: $conn->error", $module_table_hash);
}

// Create table for a module
if(isset($_POST['submit'])) {
    $sql = "CREATE TABLE $module_table_hash (
        num INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        week SMALLINT(2) UNSIGNED NOT NULL,
        session VARCHAR(128) NOT NULL,
        task VARCHAR(256) NOT NULL,
        task_duration SMALLINT(4) NOT NULL,
        task_type VARCHAR(1) DEFAULT 'I'
    )";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        throwErrorQuit("Error creating table: $conn->error", $module_table_hash);
    }
    
    // Arrays of columns
    $arr_week = $_POST['week'];
    $arr_session = $_POST['session'];
    $arr_task = $_POST['task'];
    $arr_task_duration = $_POST['task_duration']; 
    $arr_task_type = $_POST['task_type'];

    $num = sizeof($arr_week); //to help iterate over rows
    $success = false; //throws error if loop doesnt initialise
    
    // For each row
    for($key = 0; $key < $num; $key++) {
        $week = $arr_week[$key];
        $session = $arr_session[$key];
        $task = $arr_task[$key];
        $task_duration = $arr_task_duration[$key];
        $task_type = $arr_task_type[$key];
        
        // task_type validation, default I
        $task_type = strtolower($task_type);
        if ($task_type == "group" || $task_type == "g" || $task_type == "goup" || $task_type == "grop" || $task_type == "grou")
            $task_type = "G";
        else
            $task_type ="I";
        
        // duration validation, default 0
        if (is_numeric($task_duration) && $task_duration > 0 && $task_duration == round($task_duration, 0)){
            $task_duration = $task_duration;
        } else {
            $task_duration = round($task_duration, 0);
            if(is_numeric($task_duration) && $task_duration > 0 && $task_duration == round($task_duration, 0)){
                $task_duration = $task_duration;
            } else {
                $task_duration = 0;
            }
        }
        
        // week validation, default 0
        if (is_numeric($week) && $week > 0 && $week == round($week, 0)){
            $week = $week;
        } else {
            $week = round($week, 0);
            if(is_numeric($week) && $week > 0 && $week == round($week, 0)){
                $week = $week;
            } else {
                $week = 0;
            }
        }
        
        $sql = "INSERT INTO $module_table_hash (week, session, task, task_duration, task_type) 
                VALUES ('$week', '$session', '$task', '$task_duration', '$task_type')";
        if ($conn->query($sql) === TRUE) {
            $success = true;
        } else {
            echo "Error adding data: " . $conn->error;
            $success = false;
            break;
        }
     }
     if (!$success) {
            echo "<font color=Red><b><center><h5>Data could not be added. Please try again.</h5></center></b></font>";
            throwErrorQuit("Encountered error while inserting data", $module_table_hash);
     }
    $_POST = array();
}

// Function to throw error if there is a problem with a table
function throwErrorQuit ($message, $hash) {
    include("inc/db_connect.php");
    echo "Error: $message";
    $sql = "DELETE FROM $all_modules_table_name WHERE module_hash=$hash";
    $conn->query($sql);
    $sql = "DROP TABLE IF EXISTS $hash";
    $conn->query($sql);
    $_POST = array();
    die();
}

// create per student tables
$sql = "SELECT student_id, firstname, lastname, email, course_code, year
        FROM $student_list_hash";
$big_result = $conn->query($sql);
if ($big_result->num_rows > 0) {
    while ($big_row = $big_result->fetch_assoc()) {
        //each row
        $student_id = $big_row['student_id'];
        $firstname = $big_row['firstname'];
        $lastname = $big_row['lastname'];
        $email = $big_row['email'];
        $course_code = $big_row['course_code'];
        $year = $big_row['year'];
        
        //generate hash
        $to_hash = str_replace('.', '', str_replace(':', '', str_replace('-', '', str_replace(' ', '', date("Y-m-d H:i:s").microtime())))); //get accurate date
        $to_hash .= "studenttable";
        $to_hash .= $student_id . $firstname . $lastname;
        $one_student_table_hash = hash('sha256', $to_hash);
        $one_student_table_hash = substr($one_student_table_hash, 1);
        $one_student_table_hash = "s" . $one_student_table_hash;
        
        //create table for student
        $sql = "CREATE TABLE $one_student_table_hash (
            id INT AUTO_INCREMENT PRIMARY KEY,
            week INT(2) UNSIGNED NOT NULL,
            session VARCHAR(128) NOT NULL,
            task VARCHAR(256) NOT NULL,
            group_number SMALLINT(3) UNSIGNED DEFAULT NULL,
            rating ENUM('Green', 'Amber', 'Red') DEFAULT NULL,
            task_duration SMALLINT(4) NOT NULL,
            task_type VARCHAR(1) DEFAULT 'I',
            task_actual SMALLINT(4) DEFAULT NULL,
            comment VARCHAR(256) DEFAULT NULL,
            actions VARCHAR(256) DEFAULT NULL,
            meeting_date DATETIME DEFAULT NULL,
            meeting_duration INT(3) DEFAULT NULL
        )";
        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            throwErrorQuit("Error while creating per student tables: $conn->error", $module_table_hash);
        }
        
        //add sessions to the table
        $sql = "SELECT week, session, task, task_duration, task_type FROM $module_table_hash";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //for each session
                $week = $row['week'];
                $session = $row['session'];
                $task = $row['task'];
                $task_duration = $row['task_duration'];
                $task_type = $row['task_type'];
                
                $sql = "INSERT INTO $one_student_table_hash (week, session, task, task_duration, task_type)
                        VALUES ('$week', '$session', '$task', '$task_duration', '$task_type')";
                if ($conn->query($sql) === TRUE) {
                    echo "";
                } else {
                    throwErrorQuit("Error while inserint into per student table: $conn->error", $module_table_hash);
                }
            }
            //add to all_students table
            $sql = "INSERT INTO $all_students_table_name (student_id, firstname, lastname, email, course_code, year, module_name, module_hash, student_table_hash) 
                    VALUES ('$student_id', '$firstname', '$lastname', '$email', '$course_code', '$year', '$module_name', '$module_table_hash', '$one_student_table_hash')";
            if ($conn->query($sql) === TRUE) {
                echo "";
            } else {
                throwErrorQuit("Error while insering into all students table: $conn->error", $module_table_hash);
            }            
        } else {
            throwErrorQuit("Error while fetching sessions", $module_table_hash);
        }
    }
} else {
    throwErrorQuit("Encountered error while creating per student tables", $module_table_hash);
}
echo "done";

$conn->close();
include("inc/footer.php");
?>
