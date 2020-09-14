$(document).ready(function(){
    $("#add").click(function(e){
        console.log('click');
        var table = $(this).attr('for-table');  //get the target table selector
        var $tr = $(table + ">tbody>tr:last-child").clone(true, true);  //clone the last row
        var nextID = parseInt($tr.find("input.tabledit-identifier").val()) + 1; //get the ID and add one.
        $tr.find("input.tabledit-identifier").val(nextID);  //set the row identifier
        $tr.find("span.tabledit-identifier").text(nextID);  //set the row identifier
        $(table + ">tbody").append($tr);    //add the row to the table
        //$tr.find(".tabledit-edit-button").click();  //pretend to click the edit button
        //$td.find("input:not([type=hidden]), select").val("");   //wipe out the inputs.
        
        $td.find("input:not([type=hidden]), select");
        tds = tableRows[i].getElementsByTagName('td');
        for( j = 0, jlen = tds.length; j < jlen; j++) {
            r.push(tds[j]);
        }
        table.DataTable().ajax.reload();
    });
	$('#data_table').Tabledit({
        rowIdentifier: 'id',
		deleteButton: true,
		editButton: false,   		
		columns: {
            identifier: [0, 'id'],                    
            editable: [[1, 'week'], 
                     [2, 'session'],
                     [3, 'task'], 
                     [4, 'task_duration'], 
                     [5, 'task_type']]
		},
        onDraw: function() {
            //console.log('onDraw()');
        },
        onSuccess: function(data, textStatus, jqXHR) {
            //console.log('onSuccess(data, textStatus, jqXHR)');
            //console.log(data);
            //console.log(textStatus);
            //console.log(jqXHR);
            $('.tabledit-deleted-row').remove();
        },
        onFail: function(jqXHR, textStatus, errorThrown) {
            console.log('onFail(jqXHR, textStatus, errorThrown)');
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        onAlways: function() {
//            console.log('onAlways()');
        },
        onAjax: function(action, serialize) {
            //console.log('onAjax(action, serialize)');
            //console.log(action);
            //console.log(serialize);
        },
		hideIdentifier: false,
		url: 'module_edit_helper.php?module=' + $('#js-helper').data('module-id')	
	});
});