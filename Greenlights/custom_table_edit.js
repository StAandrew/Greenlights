$(document).ready(function(){
	$('#data_table').Tabledit({
		deleteButton: false,
		editButton: false,   		
		columns: {
		  identifier: [0, 'id'],                    
		  editable: [[1, 'week'], [2, 'session'], [3, 'task'], [4, 'group_number'], [5, 'rating']]
		},
		hideIdentifier: true,
		url: 'live_edit.php'		
	});
}); 