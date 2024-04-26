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

/**
 * Confirmation de suppression de toutes les donénes
 */
$(".formDataDeleteAll").on("click", function() {
	var _this = $(this);
	return core.confirm(textConfirm2, function() {
		$(location).attr("href", _this.attr("href"));
	});
});
