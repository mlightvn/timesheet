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