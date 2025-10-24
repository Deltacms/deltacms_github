/**
 * This file is part of DeltaCMS.
 */

/**
 * Confirmation de suppression
 */
$(".formDataDelete").on("click", function() {
	var _this = $(this);
	return core.confirm(textConfirm, function() {
		$(location).attr("href", _this.attr("href"));
	});
});

/* Copie du textarea correspondant au bouton (en https ou localhost)*/
$(".configPluginCopyText").on("click", function() {
	var targetId = $(this).data("target");
	var textarea = $("#" + targetId)[0];
	textarea.focus();
    textarea.select();
	navigator.clipboard.writeText(textarea.value);
});


