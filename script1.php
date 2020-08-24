<?php
include  "config.php";
include_once  "Common.php";

if($_FILES['excelDoc']['name']) 
     {
        $handle = fopen($_FILES['excelDoc']['tmp_name'], "r");
        $count = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $count++;
            if ($count == 1) {
                continue;
            }
                $student_id = $connection->real_escape_string($data[0]);
                $fname = $connection->real_escape_string($data[1]);
                $lname = $connection->real_escape_string($data[2]);
                $email = $connection->real_escape_string($data[3]);
                $course_reg = $connection->real_escape_string($data[4]);
                $course_year = $connection->real_escape_string($data[5]);
                $common = new Common();
                $SheetUpload = $common->uploadData($connection,$student_id,$fname,$lname,$email,$course_reg,$course_year);
        }
        if ($SheetUpload){
            echo "<script>alert('Sheet has been uploaded successfull !');window.location.href='index.php';</script>";
        }
        else echo "Could not upload classlist";
    }
}
?>