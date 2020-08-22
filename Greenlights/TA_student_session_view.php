<?php
include_once("db_connect.php");
$servername = "localhost";
$username = "root";
$password = "root";
$database = "TA_development";
$students_name = "All_Students";
$module = "ELECLAB1";
?>
<?php include("header.php");?>
    <title>TA Student and Session View</title>
<?php include('container.php'); ?>
    <body>
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
            print '<td>' . $name . '</td>';
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
            print '<td>' . $row['session'] . '</td>';
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
    </body>
</html>
<?php
$conn->close();
?>
