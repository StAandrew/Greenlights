$(document).ready(function(){
	$('#data_table').Tabledit({
        url: 'per_student_view_helper.php?table=' + $('#js-helper').data('table-id'),
        hideIdentifier: true,
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
        onFail: function(jqXHR, textStatus, errorThrown) {
//            console.log('onFail(jqXHR, textStatus, errorThrown)');
//            console.log(jqXHR);
//            console.log(textStatus);
//            console.log(errorThrown);
        },
	});
});