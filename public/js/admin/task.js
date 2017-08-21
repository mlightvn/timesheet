$(function() {
	$( "#modalForm" ).submit(function( event ) {
		event.preventDefault();

		var $form = $( this );
		data = $form.find( "input" ),

		$.ajax({
			type: "POST"
			, url: "/admin/api/add/task"
			, data: data
			, dataType: "json"
		}).done(function(data) {
			if(data["status"] == "success"){
				location.reload();
			}else{
				$( "#modal #alert #divMessage" ).html(data["message"]);
				$( "#modal #alert" ).toggle();
			}
		});
	});
});