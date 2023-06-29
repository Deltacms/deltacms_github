/**
 * This file is part of DeltaCMS.
 */


/**
 * Confirmation de réinitialisation
 */
$(".configInitJson").on("click", function() {
	var _this = $(this);
	return core.confirm( textConfig, function() {
		$(location).attr("href", _this.attr("href"));
	});
});

/**
 * Confirmation de suppression du compteur de téléchargements
 */
$(".configInitDownload").on("click", function() {
	var _this = $(this);
	return core.confirm( textDownload, function() {
		$(location).attr("href", _this.attr("href"));
	});
});