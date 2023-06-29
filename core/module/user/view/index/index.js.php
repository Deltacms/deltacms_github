/**
 * This file is part of DeltaCMS.
 */

/**
 * Confirmation de suppression
 */
$(".userDelete").on("click", function() {
	var _this = $(this);
	return core.confirm( textConfirm, function() {
		$(location).attr("href", _this.attr("href"));
	});
});