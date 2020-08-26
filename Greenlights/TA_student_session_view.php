<?php
include_once("db_connect.php");
$per_student_view = "TA_PS_view.php";
$per_session_view = "TA_session_view.php";
include("header.php");

$user_id = "";
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

// Set module and student list here
$students_name = "All_Students";
$module = "ELECLAB1";
echo "Module: " . $module . "<br/>";
echo "Student list: " . $students_name . "<br/>";
        ?>
        <table id="joint-table" width="1200">
            <tr>
                <div class=left-table>
                    <td style="width:50%">
                        <table id="left-table" class="table table-striped">
                            <tr>
                                <th>Student</th>
                            </tr>
<?php
// Student table
$sql = "SELECT id, firstname, lastname
        FROM $students_name";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row['firstname'][0] . ". " . $row['lastname'] . " #" . $row['id'];
        print '<tr>';
            print '<td><a href=\'' . $per_student_view . 
                '?m=' . $module . 
                '&s=' . $students_name . 
                '&student_id=' . $row['id'] . '\' >' . $name . '</a></td>';
        print '</tr>';
    }
} else {
    echo "Error: " . $sql . "<br/>" . $conn->error;
}
?>
                        </table>
                    </td>
                </div>
                <div class=right-table>
                    <td style="width:50%">
                        <table id="right-table" class="table table-striped">
                            <tr>
                                <th>Session</th>
                            </tr>
<?php
// Module table
$sql = "SELECT DISTINCT session
        FROM $module";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
     while ($row = $result->fetch_assoc()) {
        print '<tr>';
            print '<td><a href=\''. $per_session_view . 
                '?m=' . $module . 
                '&s=' . $students_name .
                '&session=' . $row['session'] . '\' >' . $row['session'] . '</a></td>';

        print '</tr>';
    }
} else {
    echo "Error: " . $sql . "<br/>" . $conn->error;
}
?>
                        </table>
                    </td>
                </div>
        </table>
<?php
include("footer.php");
$conn->close();
?>