/**
 * This file is part of DeltaCMS.
 */

/**
 * Affichage de l'icone de remontée et permettre l'aperçu.
 */
$(document).ready(function(){
	$("#backToTop").css("display","show");
});

/**
 * Aperçu en direct
 */
$("input, select").on("change", function() {

	// Option fixe pour contain et cover
	var themeBodyImageSize = $("#themeBodyImageSize").val();
	
	if(themeBodyImageSize === "cover" ||
	   themeBodyImageSize === "contain" ) {
		$("#themeBodyImageAttachment").val("fixed");
	}

	// Couleur du fond
	var css = "html{background-color:" + $("#themeBodyBackgroundColor").val() + "}";
	// Image du fond
	var themeBodyImage = $("#themeBodyImage").val();
	if(themeBodyImage) {
		css += "html{background-image:url('<?php echo helper::baseUrl(false); ?>site/file/source/" + themeBodyImage + "');background-repeat:" + $("#themeBodyImageRepeat").val() + ";background-position:" + $("#themeBodyImagePosition").val() + ";background-attachment:" + $("#themeBodyImageAttachment").val() + ";background-size:" + $("#themeBodyImageSize").val() + "}";
		css += "html{background-color:rgba(0,0,0,0);}";
	}
	else {
		css += "html{background-image:none}";
	}
	css += '#backToTop {background-color:'  + $("#themeBodyToTopBackground").val() + ';color:' + $("#themeBodyToTopColor").val() + ';}';	

	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
});
// Affiche / Cache les options de l'image du fond
$("#themeBodyImage").on("change", function() {
	if($(this).val()) {
		$("#themeBodyImageOptions").slideDown();
	}
	else {
		$("#themeBodyImageOptions").slideUp();
	}
}).trigger("change");


/* Décalage de la bannière ou de la section particulier à cette page
* petit écran et menu burger fixe et non caché
*/
if($(window).width() < 800) {
	// Annulation des décalages réalisés par theme.css ou core.js.php
	$("section").css("padding-top","10px");
	$("#site.container header, header.container").css("padding-top","0");
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