$(document).ready(function(){
	$('#data_table').Tabledit({
		deleteButton: false,
		editButton: false,   		
		columns: {
		  identifier: [0, 'id'],                    
		  editable: [[4, 'group_number'], 
                     [5, 'rating'],
                     [8, 'task_actual'], 
                     [9, 'comment'], 
                     [10, 'actions'],
                     [11, 'meeting_date'],
                     [12, 'meeting_duration']]
		},
		hideIdentifier: false,
		url: 'TA_PS_helper.php?table=' + $('#js-helper').data('table-id')		
	});
});