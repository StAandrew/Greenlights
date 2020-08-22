<?php 
$name=$_POST['modulename']; 
$weeks=$_POST['weeks'];
echo  "<center>"."<h1>".$name." - ".$weeks." weeks"."</h1>"."</center>";    
?>

<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


<script  src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
<script src="bootstable.min.js"></script>  
    <div style="text-align:right; font-size:18px; width:95%; margin-top:1%"><a href="http://www.iamrohit.in/create-editable-html-table-using-jquery-bootstrap-with-add-edit-delete-feature" >Download Page | <a href="http://iamrohit.in">Home Page</a></div>



<div style="width:70%; margin: auto;">
    

</head>
<body>
<table class="table" id="table">
    <thead>
      <tr>
        <th>Group/Individual (G/I)</th>
        <th>Teaching Event</th>
        <th>Task 1</th>
        <th>Task 2 <span style="float:right"><input type=button id="but_add">Add New Column</button></span></th>
        <th>Task 3 <span style="float:left"><button id="but_add">Add New Row</button></span> </th>
      </tr>
      </thead>
    <tbody>
      <tr>
        <td>Please specify G or I</td>
        <td>Name of Teaching Session</td>
        <td>Description of Task and Rating</td>
        <td>Description of Task and Rating</td>
      </tr> 
       <tr>
        <td>Please specify G or I</td>
        <td>Name of Teaching Session</td>
        <td>Description of Task and Rating</td>
        <td>Description of Task and Rating</td>
        
        </tr> 
    </tbody>
  </table>
    <script>    
function addColumn() {
    [...document.querySelectorAll('#table tr')].forEach((row, i) => {
        let input = document.createElement("input")
        input.setAttribute('type', 'text')
        let cell = document.createElement(i ? "td" : "th")
        cell.appendChild(input)
        row.appendChild(cell)
    });
 }
 document.querySelector('button').onclick = addColumn
 </script>  
</div>
</body>
</html>
    
    
    