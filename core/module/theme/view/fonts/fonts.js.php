/**
 * This file is part of DeltaCMS.
 */

/**
 * Confirmation de suppression
 */
$(".fontDelete").on("click", function() {
	var _this = $(this);
	var text="";
	return core.confirm(textConfirm, function() {
		$(location).attr("href", _this.attr("href"));
	});
});