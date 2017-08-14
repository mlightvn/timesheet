$(document).ready(function(){
	calculateWorkingHour();

	$("td[id^=task]").mousedown(function () {
		clicking = true;
		timeElementClick(this);
	});

	var clicking = false;

	$("td[id^=task]").mouseover(function (event) {
		if(event.buttons==1)
		{
			if(clicking == false) return;
			timeElementClick(this);
		}
	});

	$("td[id^=task]").mouseup(function () {
		clicking = false;
	});

	function timeElementClick(element) {
		var is_validate = validate(element);

		id = $(element).attr('id');
		id = id.split("[").join("\\[");
		id = id.split("]").join("\\]");

		hiddenInput = $("#input_" + id);
		if(hiddenInput.val() == "1"){
			$(".alert").addClass("w3-hide");
			$("#divMessage").html("");

			$(element).removeClass("w3-green");
			$(element).html("");
			hiddenInput.val("0");
		}else{
			if(is_validate){
				$(".alert").addClass("w3-hide");
				$("#divMessage").html("");

				$(element).addClass("w3-green");
				$(element).html("30分");
				hiddenInput.val("1");
			}else{
				var errorMessage = "この時間帯はすでに別のタスクが登録されています。<br>新たに登録する場合はすでに登録されているタスクを消してから行ってください。";
				$("#divMessage").html(errorMessage);
				$(".alert").removeClass("w3-hide");
			}
		}

		calculateWorkingHour();
	}



	function calculateWorkingHour() {
		var arrInputAllTasks = $("input[name^=input_task]");
		var length = arrInputAllTasks.length;
		var sum = 0;
		var sumOff = 0;
		var sumOn = 0;
		var taskHours = [];
		var offTaskID, onTaskID;

		jQuery.each(arrInputAllTasks, function(index, element) {
			m = this.name.match(/\[(\d+)\]\[(.*?)\]/);

			if(m != null){
				if(taskHours[m[1]] == null){
					taskHours[m[1]] = [];
					taskHours[m[1]]["minutes"] = 0;
				}

				if(m[2] == "is_off_task"){
					if(this.value == 1){
						offTaskID = m[1];
					}else{
						onTaskID = m[1];
					}
				}else{
					val = this.value;
					taskHours[m[1]][m[2]] = val;
					taskHours[m[1]]["minutes"]++;

					if(val == 1){
						sum++;
						if(offTaskID == m[1]){
							sumOff++;
						}else{
							sumOn++;
						}
					}
				}
			}
		});

		jQuery.each(taskHours, function(index, taskHour) {
				minutes = this["minutes"];
				minutes = minutes * 30 / 60;
				$("td[id=hourSum\\[" + index + "\\]]").html(timeDisplay(minutes));
			});

		sum *= 30; // minutes
		sum /= 60; // hours
		sum_s = timeDisplay(sum);

		sumOff *= 30; // minutes
		sumOff /= 60; // hours
		sumOff_s = timeDisplay(sumOff);

		sumOn *= 30; // minutes
		sumOn /= 60; // hours
		sumOn_s = timeDisplay(sumOn);

		$("#divAllWorkingHours").html(sum_s);
		$("#divAllOffWorkingHours").html(sumOff_s);
		$("#divAllOnWorkingHours").html(sumOn_s);
	}

	function timeDisplay(all_minutes) {
		var hours = (all_minutes + "").split(".")[0];
		var minutes = (all_minutes + "").split(".")[1];
		var minutes = (minutes == null) ? 0 : minutes;
		var sum_s = ((hours < 10) ? "0" + hours : hours)  + ":" + ((minutes == 5) ? "30" : "00");
		return sum_s;
	}

	$( "#datepicker" ).datepicker({
			changeMonth: true
			, changeYear: true
			, onSelect: function (dateText, inst) {
					var date = $(this).val();
					window.location.href = "/admin/report/time?date=" + date;
				}

			, monthNames: [ "1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月" ]
			, monthNamesShort: [ "1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月" ]
			, dayNames: [ "日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日" ]
			, dayNamesShort: [ "日曜","月曜","火曜","水曜","木曜","金曜","土曜" ]
			, dayNamesMin: [ "日","月","火","水","木","金","土" ]
			, weekHeader: "週"
			, showMonthAfterYear: true
			, yearSuffix: "年"

			, showButtonPanel: true
			, currentText: "今月"
		})
		.datepicker("option", {
			"dateFormat": "yy-mm-dd"
		}) // YYYY/MM/DD をセット
		.datepicker("setDate", $('#sDbRequestDate').val())
		;

	function validate(element) {
		var id = $(element).attr('id');
		var aId = id.split("][");
		var timeId = aId[aId.length - 1];
		var selectedValue = "0";
		timeId = timeId.substr(0, timeId.length - 1);

		var aHiddenInput = $("input[name^=input_task]");
		jQuery.each(aHiddenInput, function(index, hiddenInput) {
				var sHiddenId = hiddenInput.id;
				if(sHiddenId.indexOf(timeId) > 0){
					selectedValue = hiddenInput.value;
				}
				if(selectedValue == "1"){
					// console.log("Selected!");
					return false;
				}
			});
		if(selectedValue == "1"){
			return false;
		}

		return true;
	}

});
