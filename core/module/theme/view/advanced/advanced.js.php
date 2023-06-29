/**
 * This file is part of DeltaCMS.
 */

/**
 * Aperçu en direct
 */
$("#themeAdvancedCss").on("change keydown keyup", function() {
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text($(this).val())
		.appendTo("head");
});

/**
 * Confirmation de réinitialisation
 */
$("#themeAdvancedReset").on("click", function() {
	var _this = $(this);
	return core.confirm(textConfirm, function() {
		$(location).attr("href", _this.attr("href"));
	});
});