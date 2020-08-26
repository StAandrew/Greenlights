<?php
class Common
{
  public function uploadData($connection,$student_id,$fname,$lname,$email,$course_reg,$course_year)
  {
      $mainQuery = "INSERT INTO  classlist SET student_id='$student_id',first_name='$fname',last_name='$lname', email='$email', course_registration='$course_reg', course_year='$course_year'";
      $result1 = $connection->query($mainQuery) or die("Error in main Query".$connection->error);
      return $result1;
  }
}
?>