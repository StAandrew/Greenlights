<html>
<head>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel=stylesheet>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>   
<script type=text/javascript>
    $(document).ready(function(){
var html='<tr><td><input type=text name=week required>  </td><td><input type=text name=teach_event required> </td> <td><input type=text name=task required> </td><td><input type=text name=g_i required>  </td><td><input type=text name=est_time required>  </td><td><input type=text name=act_time required></td><td><input type=button name=remove id=remove value=remove></td></tr>';  
        
var x=1;
        
        
        
        
        
        
        
        
$("#add").click(function(){
    alert('ok');
    
    
    
    
    
    
});
        
    });
</script>   
    
    
    
</head>
<body>
<div class=container>
<form class="insert-form" id="insert_form" method=post action="">
<hr>
<h1>Testing</h1>
    <hr>
    <div class="input-field">
    <table class="table table-bordered">
    <tr>
    <th>Week</th>
    <th>Teaching Event</th>
    <th>Task</th>
        <th>Group/Individual</th>
    <th>Estimated Time for task</th>
    <th>Actual Time Taken</th>
    <th>Add or Remove</th>
    </tr>
    <tr>
        <td><input type=text name=week required>  </td>     
        <td><input type=text name=teach_event required> </td> <td><input type=text name=task required> </td>  
        <td><input type=text name=g_i required>  </td>  
        <td><input type=text name=est_time required>  </td> 
        <td><input type=text name=act_time required>  </td> 
        <td><input type=button name=add id=add value=Add>  </td></tr>
        
        
        </table>
    <center>
        <input type=submit name=submit
       value=Submit> 
        </center>
    
    </div>
    
    
    
    
    
    </form>
    </div>
</body>
</html>