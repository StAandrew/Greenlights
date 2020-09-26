<?php
include_once("inc/enable_debug.php");

include_once("inc/start_session.php");
include_once("inc/ta_check.php");
include_once("inc/db_connect.php");
include("inc/header.php");


if (isset($_GET['session']) && isset($_GET['module_name']) && isset($_GET['module_hash']) && isset($_GET['student_list_hash'])) {
    $session = $_GET['session'];
    $session = str_replace('_', ' ', $session);
    $module_name = $_GET['module_name'];
    $module_hash = $_GET['module_hash'];
    $student_list_hash = $_GET['student_list_hash'];
} else {
    echo "Error: get arguments was not found";
    die();
}
?>
    <body>
        <?php 
            echo "Module: " . $module_name . "<br/>";
            echo "Teaching event: " . $session . "<br/>";
        ?>
<?php
    
// Get tasks for this module from $module_hash
$tasks = array();
$sql = "SELECT week, session, task
        FROM $module_hash
        WHERE session='$session'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row['task'];
        $week = $row['week'];
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
        <table id="data_table" class="table table-striped">
            <thead>
                <tr>
                    <th>Student name</th>
                    <th>Student id</th>
                    <th>Meeting date</th>
                    <th>Overall rating</th>
<?php
$tasknum = 1;
foreach($tasks as $item) {
    $output = "Task " . $tasknum . ": " . $item;
    print "<th>" . $output . "</th>";
    $tasknum++;
}
?>
                   </tr>
            </thead>
            <tbody>
<?php
    
// For each student from $student_list_hash get their firstname, surname and id
// then get rest of info from their respective table which we get from $all_students_table_name
$sql = "SELECT student_id, firstname, lastname, course_code, year
        FROM $student_list_hash";
$stud_result = $conn->query($sql);
if ($stud_result->num_rows > 0) {
    // Get rest of info
    while ($stud = $stud_result->fetch_assoc()) {
        $student_id = $stud['student_id'];
        //get their table name
        $sql = "SELECT student_id, student_table_hash
        FROM $all_students_table_name
        WHERE student_id='$student_id'
        AND module_hash='$module_hash'";
        $small_result = $conn->query($sql);
        if ($small_result->num_rows > 0) {
            while ($sm = $small_result->fetch_assoc()) {
                $table = $sm['student_table_hash'];
            }
        } else {
            echo "SQL error: " . $sql . "<br>" . $conn->error;
        }
        
        $name = $stud['firstname'][0] . ". " . $stud['lastname'];
        $course_code = $stud['course_code'];
        $year = $stud['year'];
        
        print '<tr>';
        print '<td>' . $name . '</td>';
        print '<td>' . $stud['student_id'] . '</td>';
        $date = 0;
        
        $red_threshold = 0.3; // 0-50% of all ratings
        $amber_threshold = 0.5; // 50%-70% of all ratings
        $green_num = 0;
        $amber_num = 0;
        $red_num = 0;
        $overall_rating = 0;
        $rating_num = 0;
        // Calculate overall
        foreach($tasks as $item) {
            $sql = "SELECT task, rating
                FROM $table
                WHERE task = '$item'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                    if($row['rating'] == 'Green') {
                        $overall_rating += 3;
                        $green_num += 1;
                        $rating_num += 1;
                    } else if($row['rating'] == 'Amber') {
                        $overall_rating += 2;
                        $amber_num += 1;
                        $rating_num += 1;
                    } else if($row['rating'] == 'Red') {
                        $overall_rating += 1;
                        $red_num += 1;
                        $rating_num += 1;
                    } else {
                        //Error
                        $overall_rating = 0;
                        break;
                    }
                }
                if ($rating_num != 0) {
                    $overall_rating = $overall_rating/3*$rating_num;
                    
                    $amber_num = $amber_num / $rating_num;
                    $red_num = $red_num / $rating_num;
                    $green_num = $green_num / $rating_num;
                }
                if ($overall_rating == -1 || $rating_num == 0)
                    $overall_rating = "Unknown";
                // Check for red and amber thresholds
                else if ($red_num >= $red_threshold)
                    $overall_rating = "Red";
                else if ($amber_num + $red_num >= $amber_threshold)
                    $overall_rating = "Amber";
                // If thresholds are fine, calculate based on average
                else if ($overall_rating <= 0.3)
                    $overall_rating = "Red";
                else if ($overall_rating <= 0.7)
                    $overall_rating = "Amber";
                else 
                    $overall_rating = "Green";
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        // Loop through tasks
        foreach($tasks as $item) {
            $sql = "SELECT task, rating, meeting_date
                FROM $table
                WHERE task = '$item'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                    if (!$date) {
                        print '<td>' . $row['meeting_date'] . '</td>';
                        print '<td>' . $overall_rating . '</td>';
                        $date = 1;
                    }
                    print '<td>' . $row['rating'] . '</td>';
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        print '</tr>';
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>

                </tbody>
            </table>
    </body>
<?php
include("inc/footer.php");
$conn->close();
?>