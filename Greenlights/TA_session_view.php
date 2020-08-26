<?php
$module = $_GET['m'];
$students_name = $_GET['s'];
$session = $_GET['session'];
include_once("db_connect.php");
include("header.php");
if(isset($_SESSION['user_id'])) {
    if($_SESSION['user_type'] === "TA" || $_SESSION['user_type'] === "Lecturer" || $_SESSION['user_type'] === "admin") {
        $user_id = $_SESSION['user_id'];
    } else {
        header('Location: login.php');
        die();
    }
} else {
    header('Location: login.php');
    die();
}
?>
    <body>
        <?php 
            echo "Module: " . $module . "<br/>";
            echo "Student list: " . $students_name . "<br/>";
            echo "Session: " . $session;
        ?>
<?php
// Fetch sessions and tasks
$tasks = array();
$sql = "SELECT week, session, task
        FROM $module
        WHERE session = '$session'";
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
<div class="container home">	
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
// Fetch students data
$sql = "SELECT id, firstname, lastname, email, course_code, year
        FROM $students_name";
$stud_result = $conn->query($sql);
if ($stud_result->num_rows > 0) {
    // Loop through every student in the database
    while ($stud = $stud_result->fetch_assoc()) {
        $table = "s" . $stud['id'];
        $name = $stud['firstname'][0] . ". " . $stud['lastname'];
        $course_code = $stud['course_code'];
        $year = $stud['year'];
        
        print '<tr>';
        print '<td>' . $name . '</td>';
        print '<td>' . $stud['id'] . '</td>';
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
                        $overall_rating = -1;
                        break;
                    }
                }
                if ($rating_num != 0) {
                        $overall_rating = $overall_rating/3*$rating_num;
                    }
                $amber_num = $amber_num / $rating_num;
                $red_num = $red_num / $rating_num;
                $green_num = $green_num / $rating_num;
//                if ($overall_rating == -1 || $rating_num == 0)
//                    $overall_rating = "Unknown";
//                // Check for red and amber thresholds
//                else if ($red_num >= $red_threshold)
//                    $overall_rating = "Red";
//                else if ($amber_num + $red_num >= $amber_threshold)
//                    $overall_rating = "Amber";
//                // If thresholds are fine, calculate based on average
//                else if ($overall_rating <= 0.3)
//                    $overall_rating = "Red";
//                else if ($overall_rating <= 0.7)
//                    $overall_rating = "Amber";
//                else 
//                    $overall_rating = "Green";
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
        </div>
    </body>
</html>
<?php
$conn->close();
?>