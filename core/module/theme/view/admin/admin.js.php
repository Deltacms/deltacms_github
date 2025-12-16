/**
 * This file is part of DeltaCMS.
 */

 /**
 * Aperçu en direct
 */
$("input, select").on("change", function() {

    const titleFont = $('#adminFontTitle option:selected').text().trim();
    const textFont = $('#adminFontText option:selected').text().trim();
    //var css = "@import url('https://fonts.googleapis.com/css?family=" + titleFont + "|" + textFont + "');";
    let colors = core.colorVariants($("#adminBackgroundColor").val());
    let css = "#site{background-color:" + colors.normal + ";}";
    css += "body, .row > div {font:" + $("#adminFontTextSize").val() + " '" + textFont  + "';}";
    css += "body h1, h2, h3, h4, h5, h6, .blockTitle {font-family:'" +  titleFont + "'; color:" + $("#adminColorTitle").val() + ";}";
    css += "body:not(.editorWysiwyg),span .delta-ico-help {color:" + $("#adminColorText").val() + ";}";
    colors = core.colorVariants($("#adminColorButton").val());
    css += "input[type='checkbox']:checked + label::before,.speechBubble{ background-color:" + colors.normal + ";}";
    css += ".speechBubble::before {border-color:" + colors.normal + " transparent transparent transparent;}";
    css += ".button {background-color:" + colors.normal + ";color:" + colors.text + ";}.button:hover {background-color:" + colors.darken + ";color:" + colors.text + ";}.button:active {background-color:" + colors.veryDarken + ";color:" + colors.text + ";}";
    colors = core.colorVariants($("#adminColorGrey").val());
    css += ".button.buttonGrey {background-color: " + colors.normal + ";color:" + colors.text + ";}.button.buttonGrey:hover {background-color:" + colors.darken + ";color:" + colors.text + "}.button.buttonGrey:active {background-color:" + colors.veryDarken + ";color:" + colors.text + ";}";
    colors = core.colorVariants($("#adminColorRed").val());
    css += ".button.buttonRed {background-color: " + colors.normal + ";color:" + colors.text + ";}.button.buttonRed:hover {background-color:" + colors.darken + ";color:" + colors.text + "}.button.buttonRed:active {background-color:" + colors.veryDarken + ";color:" + colors.text + "}";
    colors = core.colorVariants($("#adminColorGreen").val());
    css += ".button.buttonGreen, button[type=submit] {background-color: " + colors.normal + ";color:" + colors.text + ";}.button.buttonGreen:hover, button[type=submit]:hover {background-color: " + colors.darken +  ";color:" + colors.text + ";}.button.buttonGreen:active, button[type=submit]:active {background-color:" + colors.veryDarken + ";color:" + colors.text + ";}";
    colors = core.colorVariants($("#adminBackGroundBlockColor").val());
    css += ".block {border: 1px solid " + $("#adminBorderBlockColor").val() + ";}.block h4 {background-color: "  + colors.normal + ";color:" + colors.text + ";}";
    css += "input[type=email],input[type=text],input[type=password],select:not(#barSelectPage),textarea:not(.editorWysiwyg),.inputFile{background-color: "  + colors.normal + ";color:" + colors.text + ";border: 1px solid " + $("#adminBorderBlockColor").val() + ";}";

	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");

}).trigger("change");

/**
 * Confirmation de réinitialisation
 */
$("#configAdminReset").on("click", function() {
	const _this = $(this);
	return core.confirm(textConfirm, function() {
		$(location).attr("href", _this.attr("href"));
	});
});
