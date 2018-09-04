$(document).ready(function(){
	$( "[name^=my_task]" ).on("click", function( event ) {
		var project_task_id = $(this).data('id');

		var flag = 0;
		if($(this).checked){
			flag = 1;
		}

		var data = {flag: flag};

		var url = "/admin/api/manage/project_task/" + project_task_id + "/my-task";
		$.ajax({
			type: "POST"
			, url: url
			, data: data
			, dataType: "json"
		}).done(function(data) {
// console.log(data);
// $( "#modal #alert #divMessage" ).html(data);
// $( "#modal #alert" ).toggle();
// return;

			// if(data["status"] == "success"){
			// 	location.reload();
			// }else{
			// 	$( "#modal #alert #divMessage" ).html(data["message"]);
			// 	$( "#modal #alert" ).toggle();
			// }
		});
	});

	$( "[name^=excel_flag]" ).on("click", function( event ) {
		var project_task_id = $(this).data('id');

		var flag = 0;
		if($(this).checked){
			flag = 1;
		}

		var data = {flag: flag};

		var url = "/admin/api/manage/project_task/" + project_task_id + "/excel-flag";
		$.ajax({
			type: "POST"
			, url: url
			, data: data
			, dataType: "json"
		}).done(function(data) {
// console.log(data);
// $( "#modal #alert #divMessage" ).html(data);
// $( "#modal #alert" ).toggle();
// return;

			// if(data["status"] == "success"){
			// 	location.reload();
			// }else{
			// 	$( "#modal #alert #divMessage" ).html(data["message"]);
			// 	$( "#modal #alert" ).toggle();
			// }
		});
	});

});