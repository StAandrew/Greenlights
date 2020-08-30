$(document).ready(function(){
	$('#data_table').Tabledit({
		deleteButton: false,
		editButton: false,   		
		columns: {
		  identifier: [0, 'ID'],                    
		  editable: [[1, 'Week'], 
                     [2, 'Teaching_Event'], 
                     [3, 'Task'], 
                     [4, 'Group_Individual'], 
                     [5, 'Estimated_Time']]
		},
		hideIdentifier: true,
		url: 'rating_live_edit.php'		
	});
});