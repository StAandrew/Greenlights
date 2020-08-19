<?php 
$file_name=$_FILES["class_list"]["name"];
$name=$_POST['modulename']; 
$weeks=$_POST['weeks'];
echo  "<center>"."<h1>".$name." - ".$weeks." weeks"."</h1>"."</center>"; 
$conn=mysqli_connect("localhost","root","root","Greenlights");
$sql="Create Table IF NOT EXISTS $name.'_classlist'";
?>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


<script  src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
<script src="bootstable.min.js"></script>  



<div style="width:70%; margin: auto;">
</head>
<body>
<table class="table" id="makeEditable">
    <thead>
      <tr>
        <th>Group/Individual (G/I)</th>
        <th>Teaching Event</th>
        <th>Task 1</th>
        <th>Task 2 <span style="float:right"><button id="but_add">Add New Row</button></span></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Please specify G or I</td>
        <td>Name of Teaching Session</td>
        <td>Description of Task and Rating</td>
        <td>Description of Task and Rating</td>
      </tr>          
    </tbody>
  </table>
</div>
<script>
 $('#makeEditable').SetEditable({ $addButton: $('#but_add')});
</script> 
</body>
</html>

<?php
if (isset ($_REQUEST['submit']))
{
$rows=
$conn=mysqli_connect ("localhost","root","root","Greenlights");
    if (!$conn)
        die ("Could not connect to the Database. Please try again later");
$sql="Create Table IF NOT EXISTS $name";
mysqli_query($conn,$sql);

foreach($html->find('table') as $table){ 
     // returns all the <tr> tag inside $table
     $all_trs = $table->find('tr');
     $count = count($all_trs);
    
}

}
?>


