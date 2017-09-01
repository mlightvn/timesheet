$(function() {
	$( "#modalForm" ).submit(function( event ) {
		event.preventDefault();

		var $form = $( this );
		data = $form.find( "input" );
console.log(data);
// console.log(data["is_off_task"]);
console.log(data["#is_off_task"]);
// 		if(!($("#is_off_task").checked)){
// 			// delete data["is_off_task"];
// 			data.remove($("#is_off_task"));
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