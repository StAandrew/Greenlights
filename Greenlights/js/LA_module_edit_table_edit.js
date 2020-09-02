$(document).ready(function(){
	$('#data_table').Tabledit({
		deleteButton: false,
		editButton: false,   		
		columns: {
		  identifier: [0, 'id'],                    
		  editable: [[0, 'week'], 
                     [1, 'session'],
                     [2, 'task'], 
                     [3, 'task_duration'], 
                     [4, 'task_type']]
		},
		hideIdentifier: false,
		url: 'LA_modules_list_live_edit.php?module=' + $('#js-helper').data('module-id')		
	});
}); 