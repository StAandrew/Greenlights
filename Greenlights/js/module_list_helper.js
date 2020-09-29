$(document).ready(function(){
	$('#your-modules-table').Tabledit({
		url: 'module_list_helper.php',
        hideIdentifier: true,
        deleteButton: true,
		editButton: false,
		columns: {
            identifier: [0, 'id'],                    
            editable: []
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
            //console.log('onFail(jqXHR, textStatus, errorThrown)');
            //console.log(jqXHR);
            //console.log(textStatus);
            //console.log(errorThrown);
        },
        onAlways: function() {
            //console.log('onAlways()');
        },
        onAjax: function(action, serialize) {
            //console.log('onAjax(action, serialize)');
            //console.log(action);
            //console.log(serialize);
        }
	});
});