$(document).ready(function(){
	$('#data_table').Tabledit({
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
		hideIdentifier: false,
		url: 'LA_modules_list_live_edit.php?module=' + $('#js-helper').data('module-id')		
	});
});