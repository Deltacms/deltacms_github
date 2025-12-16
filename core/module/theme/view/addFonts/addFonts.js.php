/**
 * This file is part of DeltaCMS.
 */

/**
 * Confirmation de suppression
 */
$(".fontDelete").on("click", function() {
	const _this = $(this);
	return core.confirm(textConfirm, function() {
		$(location).attr("href", _this.attr("href"));
	});
});