jQuery(document).ready(function($){
	$( "body" ).on("click", "[name^=my_task]", function( event ) {
		var project_task_id = $(this).data("id");

		if(project_task_id == ""){
			console.log("id is EMPTY. Check your code please");
			return;
		}

		var flag = 0;
		if($(this).prop("checked") == true){
			flag = 1;
		}

		var data = {flag: flag};

		var url = "/api/manage/project_task/" + project_task_id + "/my-task";
		$.get(url, data, function(data, textStatus, xhr) {
		}, 'json');

	});

	$( "body" ).on("click", "[name^=excel_flag]", function( event ) {
		var project_task_id = $(this).data('id');

		if(project_task_id == ""){
			console.log("id is EMPTY. Check your code please");
			return;
		}

		var flag = 0;
		if($(this).prop("checked") == true){
			flag = 1;
		}

		var data = {flag: flag};

		var url = "/api/manage/project_task/" + project_task_id + "/excel-flag";
		$.ajax({
			type: "GET"
			, url: url
			, data: data
			, dataType: "json"
		}).done(function(data) {
		});
	});

});