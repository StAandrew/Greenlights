$(document).ready(function(){
    var html='<tr><td><input type=text name=week[]  required>  </td><td><input type=text name=teach_event[]  required> </td> <td><input type=text name=task[]  required> </td><td><input type=text name=gi[]  required>  </td><td><input type=text name=est_time[]  required>  </td><td><input type=button name=remove id=remove value=remove class="btn btn-danger"></td></tr>';  

    $("#add").click(function(){
        $("#table_field").append(html);
    }); 

    $("#table_field").on('click','#remove',function(){
        $(this).closest('tr').remove();

    });
});