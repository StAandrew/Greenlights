$( document ).ready(function() {
  $('#editableTable').SetEditable({
	  columnsEd: "0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11",
	  onEdit: function(columnsEd) {
		 // console.log("===edit=="+(this));
//  group_number 3
//  rating 4
//  task_actual 6
//  comment 7
//  action 8
//  meeting_date 9
//  meeting_duration 10
        var id = columnsEd[0].childNodes[1].innerHTML;
        var week = columnsEd[0].childNodes[3].innerHTML;
        var session = columnsEd[0].childNodes[5].innerHTML;
        var task = columnsEd[0].childNodes[7].innerHTML;
		var group_number = columnsEd[0].childNodes[9].innerHTML;
        var rating = columnsEd[0].childNodes[11].innerHTML;
        var task_expected = columnsEd[0].childNodes[13].innerHTML;
        var task_actual = columnsEd[0].childNodes[15].innerHTML;
        var comment = columnsEd[0].childNodes[17].innerHTML;
        var action = columnsEd[0].childNodes[19].innerHTML;
		var meeting_date = columnsEd[0].childNodes[21].innerHTML;
        var meeting_duration = columnsEd[0].childNodes[23].innerHTML;
		$.ajax({
			type: 'POST',			
			url : "action.php",	
			dataType: "json",					
			data: {id:id, 
                   week:week, 
                   session:session, 
                   task:task, 
                   group_number:group_number, 
                   rating:rating, 
                   task_expected:task_expected, 
                   task_actual:task_actual, 
                   comment:comment, 
                   action:action, 
                   meeting_date:meeting_date, 
                   meeting_duration:meeting_duration, 
                   action:'edit'},			
			 success: function (response) {
				if(response.status) {
					// show update message
				}						
			}
		});
	  },
	  onBeforeDelete: function(columnsEd) {
	  var id = columnsEd[0].childNodes[1].innerHTML;
	  $.ajax({
			type: 'POST',			
			url : "action.php",
			dataType: "json",					
			data: {id:id, action:'delete'},			
			success: function (response) {
				if(response.status) {
					// show delete message
				}			
			}
		});
	  },
	});
});