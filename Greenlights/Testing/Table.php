<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


<script  src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
<script src="bootstable.min.js"></script>


<div style="text-align:right; font-size:18px; width:95%; margin-top:1%"><a href="http://www.iamrohit.in/create-editable-html-table-using-jquery-bootstrap-with-add-edit-delete-feature" >Download Page | <a href="http://iamrohit.in">Home Page</a></div>



<div style="width:70%; margin: auto;">
<?php 
$name=$_POST['modulename'];   
echo  "<h1>".$name."</h1>";    
?>
<table class="table" id="makeEditable">
    <thead>
      <tr>
        <th>Teaching Event</th>
        <th>Task 1</th>
        <th>Task 2 <span style="float:right"><button id="but_add">Add New Row</button></span></th>
      </tr>
    </thead>
    <tbody>
      <tr>
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

