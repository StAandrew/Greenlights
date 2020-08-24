<?php
if(isset($_POST['submit_row']))
{
 $host="localhost";
 $username="root";
 $password="root";
 $databasename="Greenlights";
 $connect=mysql_connect($host,$username,$password);
 $db=mysql_select_db($databasename);	 
 
 $name=$_POST['name'];
 $age=$_POST['age'];
 $job=$_POST['job'];
 for($i=0;$i<count($name);$i++)
 {
  if($name[$i]!="" && $age[$i]!="" && $job[$i]!="")
  {
   mysql_query("insert into employee_table values('$name[$i]','$age[$i]','$job[$i]')");	 
  }
 }
}
?>