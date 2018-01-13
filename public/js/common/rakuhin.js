$(document).ready(function(){
	$(".raku-alert .raku-closebtn").click(function(){
		$(".raku-alert").addClass("raku-hide");
	});

});

function scrollTo(element, second_speed) {
	second_speed = second_speed || 200;

	$('html, body').animate({
			scrollTop: $(element).offset().top
		}, second_speed);
}


function copyToClipboard(element_id, request_data) {
	request_data = (request_data) ? request_data : {};

	elem = document.getElementById(element_id);

	// create hidden text element, if it doesn't already exist
	var targetId = "_hiddenCopyText_";
	var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
	var origSelectionStart, origSelectionEnd;
	if (isInput) {
		// can just use the original source element for the selection and copy
		target = elem;
		target.textContent = target.value;

		origSelectionStart = elem.selectionStart;
		origSelectionEnd = elem.selectionEnd;
	} if (elem.tagName === "SELECT") {
		element_property_name = request_data["element_property_name"];
		switch(element_property_name){
			case "value":
				copyText = elem.options[elem.selectedIndex].value;
			break;
			case "text":
				copyText = elem.options[elem.selectedIndex].text;
			break;
			default:
				copyText = elem.options[elem.selectedIndex].value;
			break;
		}

		target = document.getElementById(targetId);
		if (!target) {
			var target = document.createElement("textarea");
			target.style.position = "absolute";
			target.style.left = "-9999px";
			target.style.top = "0";
			target.id = targetId;
			document.body.appendChild(target);
		}
		target.textContent = copyText;

	} else {
		// must use a temporary form element for the selection and copy
		target = document.getElementById(targetId);
		if (!target) {
			var target = document.createElement("textarea");
			target.style.position = "absolute";
			target.style.left = "-9999px";
			target.style.top = "0";
			target.id = targetId;
			document.body.appendChild(target);
		}
		target.textContent = elem.textContent;
	}
	// select the content
	var currentFocus = document.activeElement;
	target.focus();
	target.setSelectionRange(0, target.value.length);

	// copy the selection
	var succeed;
	try {
		succeed = document.execCommand("copy");
	} catch(e) {
		succeed = false;
	}
	// restore original focus
	if (currentFocus && (typeof currentFocus.focus === "function")) {
		currentFocus.focus();
	}

	if (isInput) {
		// restore prior selection
		elem.setSelectionRange(origSelectionStart, origSelectionEnd);
	} else {
		// clear temporary content
		target.textContent = "";
	}

	return succeed;
}

$(function() {
	$('[name=btnCopy]').click(function(event) {
		copied_id = $(this).val();

		tagName = $("#" + copied_id).prop("tagName");
		if(tagName === "SELECT"){
			copyToClipboard(copied_id, {element_property_name:"text"});
		}else{
			copyToClipboard(copied_id);
		}
	});
});