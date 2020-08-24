<?php
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            $studentId = "";
            if (isset($column[0])) {
                $studentId = mysqli_real_escape_string($conn, $column[0]);
            }
            $firstName = "";
            if (isset($column[1])) {
                $firstName = mysqli_real_escape_string($conn, $column[1]);
            }
            $lastName = "";
            if (isset($column[2])) {
                $lastName = mysqli_real_escape_string($conn, $column[2]);
            }
            $email = "";
            if (isset($column[3])) {
                $email = mysqli_real_escape_string($conn, $column[3]);
            }
            $courseRegistration = "";
            if (isset($column[4])) {
                $courseRegistration = mysqli_real_escape_string($conn, $column[4]);
            }
             $courseYear = "";
            if (isset($column[5])) {
                $courseYear = mysqli_real_escape_string($conn, $column[5]);
            }
            
            $sqlInsert = "INSERT into users (studentId,firstName,lastName,email,courseRegistration, courseYear)
                   values (?,?,?,?,?)";
            $paramType = "issss";
            $paramArray = array(
                $userId,
                $userName,
                $password,
                $firstName,
                $lastName
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
            
            if (! empty($insertId)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>