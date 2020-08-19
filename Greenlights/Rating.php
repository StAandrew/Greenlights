<html>
<body>
<?php
$rows=$_REQUEST['weeks'];
$name_of_table=$_REQUEST['module_name'];
?>
<?php require_once 'Rating.php'; ?>
<script language="javascript">
<meta charset=utf-8 />  
<table id="myTable" border="1"> 
</table><form> 
<input type="button" onclick="createTable()" value="Generate Table to Input Rating"> 
</form>


function createTable()
{
rn = <?php echo $rows; ?> ;
cn = 2
  
 for(var r=0;r<parseInt(rn,10);r++)
  {
   var x=document.getElementById('myTable').insertRow(r);
   for(var c=0;c<parseInt(cn,10);c++)  
    {
     var y=  x.insertCell(c);
     y.innerHTML="Row-"+r+" Column-"+c; 
    }
   }
}
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    


    
    
    
    
    
    
    
    
    
    
    
    
    
    
?>
</body>
</html>