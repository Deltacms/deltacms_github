/**
 * This file is part of DeltaCMS.
 */

/**
 * Confirmation de réinitialisation
 */
$("#configManageReset").on("click", function() {
	var _this = $(this);
	return core.confirm(textConfirm, function() {
		$(location).attr("href", _this.attr("href"));
	});
});

/**
 * Confirmation de changement de thème
 */
$("#themeImportSubmit").on("click", function() {
	return core.confirm(textConfirm2, function() {
		$('#themeManageForm').submit();
	});
});

// Couleur des boutons submit de sauvegarde et d'export
var bgcolor = <?php echo '"'.$this->getData(['admin', 'backgroundColorButton' ]).'"'; ?>;
var color = <?php echo '"'.helper::colorVariants($this->getData(['admin', 'backgroundColorButton']))['text'].'"'; ?>;
$(".themeSave").css('background-color', bgcolor);
$(".themeSave").css('color', color);