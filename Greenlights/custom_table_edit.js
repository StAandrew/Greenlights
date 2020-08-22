$(document).ready(function(){
	$('#data_table').Tabledit({
		deleteButton: false,
		editButton: false,   		
		columns: {
		  identifier: [0, 'id'],                    
		  editable: [[1, 'week'],
                     [2, 'session'],
                     [3, 'task'], 
                     [4, 'group_number'], 
                     [5, 'rating'],
                     [6, 'task_expected'], 
                     [7, 'task_actual'], 
                     [8, 'comment'], 
                     [9, 'action'],
                     [10, 'meeting_date'],
                     [11, 'meeting_action']]
		},
		hideIdentifier: true,
		url: 'live_edit.php'		
	});
}); 