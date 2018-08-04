$(function() {
	$( "#modalForm" ).submit(function( event ) {
		event.preventDefault();

// 		var $form = $( this );
// 		data = $form.find( "input" );
// console.log(data);

// 		if(!($("#is_off").checked)){
// 			// delete data["is_off"];
// 			data.remove($("#is_off"));
// 		}
// console.log(data);

// 		$.ajax({
// 			type: "POST"
// 			, url: "/admin/api/add/task"
// 			, data: data
// 			, dataType: "json"
// 		}).done(function(data) {
// // console.log(data);
// // $( "#modal #alert #divMessage" ).html(data);
// // $( "#modal #alert" ).toggle();
// // return;
// 			if(data["status"] == "success"){
// 				location.reload();
// 			}else{
// 				$( "#modal #alert #divMessage" ).html(data["message"]);
// 				$( "#modal #alert" ).toggle();
// 			}
// 		});
	});
});