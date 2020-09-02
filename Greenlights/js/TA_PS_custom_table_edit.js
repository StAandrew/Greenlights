$(document).ready(function(){
	$('#data_table').Tabledit({
		deleteButton: false,
		editButton: false,   		
		columns: {
		  identifier: [0, 'id'],                    
		  editable: [[3, 'group_number'], 
                     [4, 'rating'],
                     [6, 'task_actual'], 
                     [7, 'comment'], 
                     [8, 'actions'],
                     [9, 'meeting_date'],
                     [10, 'meeting_duration']]
		},
		hideIdentifier: false,
		url: 'TA_PS_live_edit.php?student_id=' + $('#js-helper').data('student-id')		
	});
}); 