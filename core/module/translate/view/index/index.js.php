/**
 * This file is part of DeltaCMS.
 */

$("#translateLangBase").on("change", function() {
	// Menu fixe à afficher
	if($("#translateLangBase").val() === 'none') {
		$("#translateOtherLangBase").slideDown();
	}
	else {
		$("#translateOtherLangBase").slideUp();
	}
});

$(function () {
	// Menu fixe à afficher
	if($("#translateLangBase").val() === 'none') {
		$("#translateOtherLangBase").slideDown();
	}
	else {
		$("#translateOtherLangBase").slideUp();
	}
});
