/**
 * This file is part of DeltaCMS.
 */


let tmpImg = new Image();


$(document).ready(function(){
	$("header").css("line-height", "");
	$("header").css("height", "");
});

/**
 * Aperçu en direct
 */
$("input, select").on("change", function() {
	// Aperçu de la mise en forme du texte
	const headerFont = $('#themeHeaderFont option:selected').text().trim();
	$('#themeHeaderTextPreview').css({
        fontFamily: headerFont,
        fontSize: $('#themeHeaderFontSize').val(),
		fontWeight: $('#themeHeaderFontWeight').val(),
        textTransform: $('#themeHeaderTextTransform').val(),
		color: $('#themeHeaderTextColor').val(),
		backgroundColor: $('#themeHeaderBackgroundColor').val()
    });

	let css = "";
	// Bannière animée avec Swiper
	if ($("#themeHeaderFeature").val() == "swiper") {
		// masque l'option hauteur
		$("#themeHeaderHeightWrapper").hide();
		// Masque le contenu perso et le papier peint
		$("#featureContent").hide();
		$("#themeHeaderTitle").hide();
		css = "header #headerSwiper {background-color:" + $("#themeHeaderBackgroundColor").val() + ";}";
	} else {
		$("#themeHeaderHeightWrapper").show();
	}

	// Contenu perso
	if ($("#themeHeaderFeature").val() == "feature") {
		css = "header{min-height: 20px;height:" + $("#themeHeaderHeight").val() + ";overflow:hidden;background-position:top;background-repeat: no-repeat;line-height:1.15;";
		css += "background-color:" + $("#themeHeaderBackgroundColor").val() + ";background-image:unset;text-align:unset;color:" + $("#themeHeaderTextColor").val() + "}";
		$("#featureContent").appendTo("header").show();
		$("#themeHeaderTitle").hide();
		$("#headerSwiper").hide();
	}

	// Couleurs, image, alignement et hauteur de la bannière papier peint
	if ($("#themeHeaderFeature").val() == "wallpaper") {
		// Masque le contenu perso ou la bannière Swiper
		$("#featureContent").hide();
		$("#headerSwiper").hide();
		css = "header #wallPaper{text-align:" + $("#themeHeaderTextAlign").val() + ";";
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
			css += "background-color:" + $("#themeHeaderBackgroundColor").val() + ";";
			if( $("#themeHeaderHeight").val() !== 'unset'){
				css += "line-height:" + $("#themeHeaderHeight").val() + ";height:" + $("#themeHeaderHeight").val() + ";";
			} else {
				// valeur unset remplacée par la hauteur de l'image
				tmpImg.onload = function () {
					css +="line-height:" + tmpImg.height + "px;height:" + tmpImg.height + "px;";
        		};
				tmpImg.src= "<?php echo helper::baseUrl(false); ?>" + "site/file/source/" + $("#themeHeaderImage").val();
			}
		css +="}";
		} else {
			// Pas d'image sélectionnée
			css += "background-image:none;";
			css += "background-color:" + $("#themeHeaderBackgroundColor").val() + ";";
			css += "min-height: 20px;line-height:" + $("#themeHeaderHeight").val() + ";height:" + $("#themeHeaderHeight").val() + "}";
		}
        // Taille, couleur, épaisseur et capitalisation du titre de la bannière
        css += "header #wallPaper span{font-family:'" + headerFont + "';font-weight:" + $("#themeHeaderFontWeight").val() + ";font-size:" + $("#themeHeaderFontSize").val() + ";text-transform:" + $("#themeHeaderTextTransform").val() + ";color:" + $("#themeHeaderTextColor").val() + "}";
		// Cache le titre de la bannière
		if($("#themeHeaderTextHide").is(":checked")) {
			$("#themeHeaderTitle").hide();
		}
		else {
			$("#themeHeaderTitle").show();
		}
	}

	// Position de la bannière
	let positionNav = <?php echo json_encode($this->getData(['theme', 'menu', 'position'])); ?>;
	let positionHeader = $("#themeHeaderPosition").val();
	switch(positionHeader) {
		case 'hide':
			//$("nav").show().prependTo("#site");
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
	}
	else if ($(this).val() === 'hide') {
		$("#themeHeaderContainerWrapper").slideUp();
		$("#themeHeaderWideWrapper").slideUp();
	} else {
		$("#themeHeaderWideWrapper").slideDown();
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
		$("#themeHeaderTextColorWrapper").show();
		$(".swiperContainer").hide();
	}
	if($(this).val() === 'swiper') {
		$(".swiperContainer").show();
		$(".colorsContainer").show();
		$(".featureContainer").hide();
		$(".wallpaperContainer").hide();
		$("#themeHeaderTextColorWrapper").hide();
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
	const positionNav = <?php echo json_encode($this->getData(['theme', 'menu', 'position'])); ?>;
	const positionHeader = <?php echo json_encode($this->getData(['theme', 'header', 'position'])); ?>;
	const tinyHidden = <?php echo json_encode($this->getData(['theme', 'header', 'tinyHidden'])); ?>;
	// bannerMenuHeight et bannerMenuHeightSection transmis par core.php / showMenu()
	const burgerFixed = <?php echo json_encode($this->getData(['theme', 'menu', 'burgerFixed'])); ?>;
	const burgerOverlay = <?php echo json_encode($this->getData(['theme', 'menu', 'burgerOverlay'])); ?>;
	// Spécialement pour une bannière papier peint
	const headerFeature = <?php echo json_encode($this->getData(['theme', 'header', 'feature'])); ?>;
	const headerBgColor = <?php echo json_encode($this->getData(['theme', 'header', 'backgroundColor'])); ?>;
	if( positionNav !=='hide' && burgerFixed === true && burgerOverlay === false){
		// Décalage de la bannière de la hauteur du menu
		$("header").css("padding-top",bannerMenuHeight);
		if ( headerFeature === "wallpaper" ){
			$("section").css("padding-top",bannerMenuHeightSection);
			$("nav.navfixedburgerconnected #toggle").css("background-color",headerBgColor);
		}
	}
	if( positionNav !=='hide' && burgerFixed === true && positionHeader === 'hide' ){
		// si bannière cachée décalage de la section
		$("header").removeClass("displayNone");
		$("section").css("padding-top",bannerMenuHeightSection);
	}
	if( positionHeader === 'body' && tinyHidden === true) $("header.bannerDisplay").css("display","block");
}
