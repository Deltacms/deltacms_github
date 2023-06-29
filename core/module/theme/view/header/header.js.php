/**
 * This file is part of DeltaCMS.
 */
 

var tmpImg = new Image();

 
$(document).ready(function(){
	$("header").css("line-height", "");
	$("header").css("height", "");
});

/**
 * Aperçu en direct
 */
$("input, select").on("change", function() {
	
	var css = "";
	// Bannière animée avec Swiper
	if ($("#themeHeaderFeature").val() == "swiper") {
		// masque l'option hauteur
		$("#themeHeaderHeightWrapper").hide();
		// Masque le contenu perso et le papier peint
		$("#featureContent").hide();
		$("#themeHeaderTitle").hide();
	} else {
		$("#themeHeaderHeightWrapper").show();
	}

	// Contenu perso
	if ($("#themeHeaderFeature").val() == "feature") {
		css = "header{min-height: 20px; height:" + $("#themeHeaderHeight").val() + "; overflow:hidden; background-position:top; background-repeat: no-repeat; line-height:1.15; background-color:unset; background-image:unset; text-align:unset;}";
		
		$("#featureContent").appendTo("header").show();
		$("#themeHeaderTitle").hide();
		$("#headerSwiper").hide();
	}
	

	// Couleurs, image, alignement et hauteur de la bannière
	if ($("#themeHeaderFeature").val() == "wallpaper") {
	
		// Masque le contenu perso ou la bannière Swiper
		$("#featureContent").hide();
		$("#headerSwiper").hide();
			
		var headerFont = $("#themeHeaderFont").val();
		css = "header{text-align:" + $("#themeHeaderTextAlign").val() + ";";
		
		// Sélection d'une image réalisée
		if( $("#themeHeaderImage").val() !== ""){
			tmpImg.src= "<?php echo helper::baseUrl(false); ?>" + "site/file/source/" + $("#themeHeaderImage").val();
			// Déterminer la taille de l'image
			tmpImg.onload = function() {
				// Informations affichées
				$("#themeHeaderImageHeight").html(tmpImg.height + "px");
				$("#themeHeaderImageWidth").html(tmpImg.width + "px");
				$("#themeHeaderImageRatio").html(tmpImg.width / tmpImg.height);
			};	
			css += "background-image:url('<?php echo helper::baseUrl(false); ?>site/file/source/" + $("#themeHeaderImage").val() + "');background-repeat:" + $("#themeHeaderImageRepeat").val() + ";background-position:" + $("#themeHeaderImagePosition").val() + ";";
			css += "background-size:" + $("#themeHeaderImageContainer").val() + ";";
			if( $("#themeHeaderHeight").val() !== 'unset'){
				css += "line-height:" + $("#themeHeaderHeight").val() + ";height:" + $("#themeHeaderHeight").val() + "}";
			} else {
				// valeur unset remplacée par la hauteur de l'image	
				tmpImg.src= "<?php echo helper::baseUrl(false); ?>" + "site/file/source/" + $("#themeHeaderImage").val();
				css += "line-height:" + tmpImg.height + "px" + ";height:" + tmpImg.height + "px" + "}";
			}
		} else {
			// Pas d'image sélectionnée
			css += "background-image:none;";
			css += "min-height: 20px;line-height:" + $("#themeHeaderHeight").val() + "; height:" + $("#themeHeaderHeight").val() + "}";
		}

        // Taille, couleur, épaisseur et capitalisation du titre de la bannière
        css += "header span{font-family:'" + headerFont.replace(/\+/g, " ") + "',sans-serif;font-weight:" + $("#themeHeaderFontWeight").val() + ";font-size:" + $("#themeHeaderFontSize").val() + ";text-transform:" + $("#themeHeaderTextTransform").val() + ";color:" + $("#themeHeaderTextColor").val() + "}";		

		// Cache le titre de la bannière
		if($("#themeHeaderTextHide").is(":checked")) {
			$("#themeHeaderTitle").hide();
		}
		else {
			$("#themeHeaderTitle").show();
		}
	}

	// Couleur du fond
	css += "header{background-color:" + $("#themeHeaderBackgroundColor").val() + ";}";


	// Position de la bannière
	var positionNav = <?php echo json_encode($this->getData(['theme', 'menu', 'position'])); ?>;
	var positionHeader = $("#themeHeaderPosition").val();
	switch(positionHeader) {
		case 'hide':
			$("nav").show().prependTo("#site");
			$("header").hide();
			break;
		case 'site':
			$("header").show().prependTo("#site");
			// Position du menu
			switch (positionNav) {
				case "body-first":
					$("nav").show().insertAfter("header");
					break;
				case "site-first":
					$("nav").show().prependTo("#site");
					// Supprime le margin en trop du menu
					if(<?php echo json_encode($this->getData(['theme', 'menu', 'margin'])); ?>) {
						css += 'nav{margin:0 20px}';
					}
					break;
				case "body-second":
				case "site-second":
					$("nav").show().insertAfter("header");
					// Supprime le margin en trop du menu
					if(<?php echo json_encode($this->getData(['theme', 'menu', 'margin'])); ?>) {
						css += 'nav{margin:0 20px}';
					}
					break;
				case "top":				
					break;
			}
			break;
		case 'body':
			// Position du menu
			switch (positionNav) {
				case "top":
					$("header").show().insertAfter("nav");
					break;
				case "site-first":
				case "body-first":
					$("header").show().insertAfter("#bar");
					$("nav").show().insertAfter("#bar");
					break;
				case "site-second":
				case "body-second":
					$("header").show().insertAfter("#bar");
					$("nav").show().insertAfter("header");
					break;

			}
	}

	// Marge dans le site
	if(	$("#themeHeaderMargin").is(":checked") &&
		$("#themeHeaderPosition").val() === "site"
		) {	
			css += 'header{margin:20px 20px 0 20px !important;}';
		/*} else { 
			css += 'header{margin:0 !important;}';*/
    }

	// Largeur du header
	switch ($("#themeHeaderWide").val()) {
		case "container":
			$("header").addClass("container");
			break;
		case "none":
			$("header").removeClass("container");
			break;
	}

	// La bannière est cachée, déplacer le menu dans le site
	if (positionHeader === "hide" &&
		(positionNav === "body-first" ||
		 positionNav === "site-first" ||
		 positionNav === "body-second" ||
		 positionNav === "site-second"
		 )) {
			$("nav").show().prependTo("#site");
	}

	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
}).trigger("change");

// Affiche / Cache les options de l'image du fond
$("#themeHeaderImage").on("change", function() {
	if($(this).val()) {
		$("#themeHeaderImageOptions").slideDown();
	}
	else {
		$("#themeHeaderImageOptions").slideUp(function() {
			// $("#themeHeaderTextHide").prop("checked", false).trigger("change");
		});
	}
}).trigger("change");

// Affiche / Cache les options de la position
$("#themeHeaderPosition").on("change", function() {
	if($(this).val() === 'site') {
		$("#themeHeaderContainerWrapper").slideUp();
		$("#themeHeaderPositionOptions").slideDown();
		$("#themeHeaderWideWrapper").slideUp();
		$("#themeHeaderMarginWrapper").slideDown();
	}
	else if ($(this).val() === 'hide') {
		$("#themeHeaderContainerWrapper").slideUp();
		$("#themeHeaderWideWrapper").slideUp();
		$("#themeHeaderMarginWrapper").slideUp();
		$("#themeHeaderMargin").prop("checked", false);
		$("#themeHeaderPositionOptions").slideUp(function() {
			$("#themeHeaderMargin").prop("checked", false).trigger("change");
		});
	} else {
		$("#themeHeaderWideWrapper").slideDown();
		$("#themeHeaderMarginWrapper").slideUp();
		$("#themeHeaderMargin").prop("checked", false);
	}
}).trigger("change");



// Affiche / Cache l'option bannière masquée en écran réduit
$("#themeHeaderPosition").on("change", function() {
	if($(this).val() === 'hide') {
		$("#themeHeaderSmallDisplay").slideUp();
		$("#themeHeaderHomePage").slideUp();
	}
	else {
		$("#themeHeaderSmallDisplay").slideDown();
		$("#themeHeaderHomePage").slideDown();
	}
}).trigger("change");

// Affiche les blocs selon le type bannière
$("#themeHeaderFeature").on("change", function() {
	if($(this).val() === 'wallpaper') {
		$(".wallpaperContainer").show();
		$(".colorsContainer").show();
		$(".featureContainer").hide();
		$("#themeHeaderTextColorWrapper").show();
		$(".swiperContainer").hide();
	}
	if($(this).val() === 'feature') {
		$(".featureContainer").show();
		$(".colorsContainer").show();
		$(".wallpaperContainer").hide();
		$("#themeHeaderTextColorWrapper").hide();
		$(".swiperContainer").hide();
	}
	if($(this).val() === 'swiper') {
		$(".swiperContainer").show();
		$(".colorsContainer").hide();
		$(".featureContainer").hide();
		$(".wallpaperContainer").hide();
		$("#themeHeaderTextColorWrapper").hide();
	}
}).trigger("change");

/* Décalage de la bannière ou de la section particulier à cette page
* petit écran et menu burger fixe et non caché
*/
if($(window).width() < 800) {
	// Variables du thème
	var positionNav = <?php echo json_encode($this->getData(['theme', 'menu', 'position'])); ?>;
	var positionHeader = <?php echo json_encode($this->getData(['theme', 'header', 'position'])); ?>;
	var tinyHidden = <?php echo json_encode($this->getData(['theme', 'header', 'tinyHidden'])); ?>;
	var bannerMenuHeight = $("nav #toggle").css("height");
	bannerMenuHeightSection = ( parseInt( bannerMenuHeight.replace("px","") ) + 10 ).toString() + "px";
	var burgerFixed = <?php echo json_encode($this->getData(['theme', 'menu', 'burgerFixed'])); ?>;
	var burgerOverlay = <?php echo json_encode($this->getData(['theme', 'menu', 'burgerOverlay'])); ?>;
	if( positionNav !=='hide' && burgerFixed === true && burgerOverlay === false){
		// Décalage de la bannière de la hauteur du menu
		$("header").css("padding-top",bannerMenuHeight);
	}
	if( positionNav !=='hide' && burgerFixed === true && positionHeader === 'hide' ){
		// si bannière cachée décalage de la section
		$("header").removeClass("displayNone");
		$("section").css("padding-top",bannerMenuHeightSection);
	}
	if( positionHeader === 'body' && tinyHidden === true) $("header.bannerDisplay").css("display","block");
}
