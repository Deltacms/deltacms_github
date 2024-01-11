/**
 * This file is part of DeltaCMS.
 */



/**
 * Aperçu en direct
 */
$("input, select").on("change",function() {

	/**
	* Option de marge si la taille n'est pas fluide
	*/
	if ($('#themeSiteWidth').val() === '100%') {
		$("#themeSiteMarginWrapper").prop("checked", true);
		$("#themeSiteMarginWrapper").hide();
	} else {
		$("#themeSiteMarginWrapper").show();
	}

	/**
	 * Aperçu dans la boîte
	 */

	var titleFont = $("#themeTitleFont").val();
	var textFont = $("#themeTextFont").val();
	// Couleurs des boutons
	var colors = core.colorVariants($("#themeButtonBackgroundColor").val());
	css = ".button.buttonSubmitPreview{background-color:" + colors.normal + ";}";
	css += ".button.buttonSubmitPreview:hover{background-color:" + colors.darken + "}";
	css += ".button.buttonSubmitPreview{color:" + colors.text + ";}";

	// Couleurs des liens
	var colors = core.colorVariants($("#themeTextLinkColor").val());
	css += "a.urlPreview{color:" + colors.normal + "}";
	css += "a.urlPreview:hover{color:" + colors.darken + "}";
	// Couleur, polices, épaisseur et capitalisation de caractères des titres
	css += ".headerPreview,.headerPreview{color:" + $("#themeTitleTextColor").val() + ";font-family:'" + titleFont.replace(/\+/g, " ") + "',sans-serif;font-weight:" + $("#themeTitleFontWeight").val() + ";text-transform:" + $("#themeTitleTextTransform").val() + "}";
	// Police de caractères
	// Police + couleur
	css += ".textPreview,.urlPreview{color:" + $("#themeTextTextColor").val() + ";font-family:'" + textFont.replace(/\+/g, " ") + "',sans-serif; font-size:" + $("#themeTextFontSize").val() + ";}";
	// Couleur des liens
	//css += "a.preview,.buttonSubmitPreview{font-family:'" + textFont.replace(/\+/g, " ") + "',sans-serif}";

	// Taille du texte
	// Couleur du texte
	css += "p.preview{color:" + $("#themeTextTextColor").val() + "}";

	/**
	 * Aperçu réel
	 */

	// Taille du site
	if ($("#themeSiteWidth").val() === "75vw") {
		css += ".button, button{font-size:0.8em;}";
	} else {
		css += ".button, button{font-size:1em;}";
	}
	// Largeur du site
	var margin = '20px';
	if ( $("#themeSiteMargin").is(":checked") || $(window).width() < 800 ) margin = '0px' ;
	css += ".container{max-width:" + $("#themeSiteWidth").val() + "}";
	if ($("#themeSiteWidth").val() === "100%") {
		css += "#site{margin: 0px auto;} body{margin:0 auto;}  #bar{margin:0 auto;} body > header{margin:0 auto;} body > nav {margin: 0 auto;} body > footer {margin:0 auto;}";
	} else {
		css += "#site{margin: " + margin + " auto !important;} body{margin:0px 10px;}  #bar{margin: 0 -10px;} body > header{margin: 0 -10px;} body > nav {margin: 0 -10px;} body > footer {margin: 0 -10px;} ";
	}
	// Couleur du site, arrondi sur les coins du site et ombre sur les bords du site
	//css += "#site{background-color:" + $("#themeSiteBackgroundColor").val() + ";border-radius:" + $("#themeSiteRadius").val() + ";box-shadow:" + $("#themeSiteShadow").val() + " #212223}";

	css += "#site{border-radius:" + $("#themeSiteRadius").val() + ";box-shadow:" + $("#themeSiteShadow").val() + " #212223}";

	// Couleur ou image de fond
	var backgroundImage = <?php if( $this->getData(['theme','body','image']) !== '') { echo json_encode(helper::baseUrl(false) . self::FILE_DIR . 'source/' . $this->getData(['theme','body','image']));} else { echo 'null';} ?> ;
	var backgroundcolor = <?php echo json_encode($this->getdata(['theme','body','backgroundColor'])); ?>;
	if(backgroundImage) {
		css += "div.bodybackground{background-image:url(" + backgroundImage + ");background-repeat:" + $("#themeBodyImageRepeat").val() + ";background-position:" + $("#themeBodyImagePosition").val() + ";background-attachment:" + $("#themeBodyImageAttachment").val() + ";background-size:" + $("#themeBodyImageSize").val() + "}";
		css += "div.bodybackground{background-color:rgba(0,0,0,0);}";
	}
	else {
		css += "div.bodybackground{background-image:none}";
	}
	// css += '#backToTop {background-color:'  + backgroundcolor + ';color:' + $("#themeBodyToTopColor").val() + ';}';
	css += '#backToTop {color:' + $("#themeBodyToTopColor").val() + ';}';
	css += "div.bgPreview{padding: 5px;background-color:" + $("#themeSiteBackgroundColor").val() + ";}";

	// Les blocs

	var colors = core.colorVariants($("#themeBlockBackgroundTitleColor").val());
	css += ".block.preview {background-color: " + $("#themeBlockBackgroundColor").val() + ";padding: 20px 20px 10px;margin: 20px 0;	word-wrap: break-word;border-radius: " + $("#themeBlockBorderRadius").val() + ";border: 1px solid " + $("#themeBlockBorderColor").val() + ";box-shadow: " + $("#themeBlockBorderShadow").val() + " " + $("#themeBlockBorderColor").val() + ";}.block.preview .blockTitle.preview {background: "  + colors.normal + ";color:" + colors.text + ";font-family:'" + titleFont.replace(/\+/g, " ") + "',sans-serif;margin: -20px -20px 10px -20px; padding: 10px;border-radius: " + $("#themeBlockBorderRadius").val() + " " + $("#themeBlockBorderRadius").val() + " 0px 0px;}";

	/**
	 * Injection dans le DOM
	 */
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");

}).trigger("change");


/* Décalage de la bannière ou de la section particulier à cette page
* petit écran et menu burger fixe et non caché
*/
if($(window).width() < 800) {
	// Annulation des décalages réalisés par theme.css ou core.js.php
	$("section").css("padding-top","10px");
	$("#site.container header, header.container").css("padding-top","0");
	$(".container").css("max-width","100%");
	// Variables du thème
	var positionNav = <?php echo json_encode($this->getData(['theme', 'menu', 'position'])); ?>;
	var positionHeader = <?php echo json_encode($this->getData(['theme', 'header', 'position'])); ?>;
	var tinyHidden = <?php echo json_encode($this->getData(['theme', 'header', 'tinyHidden'])); ?>;
	// bannerMenuHeight et bannerMenuHeightSection transmis par core.php / showMenu()
	var burgerFixed = <?php echo json_encode($this->getData(['theme', 'menu', 'burgerFixed'])); ?>;
	var burgerOverlay = <?php echo json_encode($this->getData(['theme', 'menu', 'burgerOverlay'])); ?>;
	if( positionNav !=='hide' && burgerFixed === true && burgerOverlay === false){
		// Bannière masquée décaler la section
		if( tinyHidden === true ){
			$("section").css("padding-top",bannerMenuHeightSection);
		} else {
		// Bannière non masquée décaler la bannière
			$("header").css("padding-top",bannerMenuHeight);
		}
	}
	if( positionNav !=='hide' && burgerFixed === true && ( burgerOverlay === true && tinyHidden === true || positionHeader === 'hide' )){
		// Bannière masquée ou cachée décaler la section
		$("section").css("padding-top",bannerMenuHeightSection); 
	}
}
