/**
 * This file is part of DeltaCMS.
 */

/**
 * Ajout des overlays
 */
$("<a>")
	.addClass("themeOverlay")
	.attr({
		"id": "themeOverlayBody",
		"href": "<?php echo helper::baseUrl(); ?>theme/body"
	})
	.appendTo("body");
$("<a>")
	.addClass("themeOverlay")
	.attr({
		"id": "themeOverlayHeader",
		"href": "<?php echo helper::baseUrl(); ?>theme/header"
	})
	.appendTo("header");
$("<a>")
	.addClass("themeOverlay")
	.attr({
		"id": "themeOverlayMenu",
		"href": "<?php echo helper::baseUrl(); ?>theme/menu"
	})
	.appendTo("nav");
$("<a>")
	.addClass("themeOverlay")
	.attr({
		"id": "themeOverlaySite",
		"href": "<?php echo helper::baseUrl(); ?>theme/site"
	})
	.appendTo("#site");
$("<a>")
	.addClass("themeOverlay themeOverlayHideBackground")
	.attr({
		"id": "themeOverlaySection",
		"href": "<?php echo helper::baseUrl(); ?>theme/site"
	})
	.appendTo("section");
$("<a>")
	.addClass("themeOverlay")
	.attr({
		"id": "themeOverlayFooter",
		"href": "<?php echo helper::baseUrl(); ?>theme/footer"
	})
	.appendTo("footer");

/**
 * Affiche les zones cachées
 */
$("#themeShowAll").on("click", function() {
	if( $(window).width() >= 800 ){
		$("header.displayNone, nav.displayNone, footer.displayNone").slideToggle();
	} else {
		$("header.displayNone, nav.displayNone, footer.displayNone, header.bannerDisplay").slideToggle();
	}
});

/**
 * Simule un survol du site lors du survol de la section
 */
$("section")
	.on("mouseover", function() {
		$("#themeOverlaySite:not(.themeOverlayTriggerHover)").addClass("themeOverlayTriggerHover");
	})
	.on("mouseleave", function() {
		$("#themeOverlaySite.themeOverlayTriggerHover").removeClass("themeOverlayTriggerHover");
	});

/**
 * Affiche le bouton zones cachées en grand écran et en petit écran
 */
 var tinyHidden = "<?php echo $this->getData(['theme', 'header', 'tinyHidden']); ?>" ;
 <?php 
 include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
 if( $this->getData(['theme', 'header', 'position']) === 'hide'
	OR $this->getData(['theme', 'menu', 'position']) === 'hide'
	OR $this->getData(['theme', 'footer', 'position']) === 'hide' ) { ?>
	$(".showAll").css("display","block");
	$(".speechBubble").text(" <?php echo $text['core_theme_view']['index'][0]; ?> ");
<?php } else { ?>
	if( $(window).width() >= 800 || tinyHidden !== "1"){
		$(".showAll").css("display","none");
		$(".speechBubble").text(" <?php echo $text['core_theme_view']['index'][8]; ?> ");
	} else {
		$(".showAll").css("display","block");
		$(".speechBubble").text(" <?php echo $text['core_theme_view']['index'][0]; ?> ");
	}
<?php } ?>

/* Décalage de la bannière ou de la section particulier à cette page
* en petit écran
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
	if( positionNav !=='hide' && burgerFixed === true){
		// si bannière masquée
		if( tinyHidden === true ){
			// Décalage de la bannière et de la section
			$("header").css("padding-top",bannerMenuHeight);
			$("section").css("padding-top",bannerMenuHeightSection);
		} else {
		// Bannière non masquée décaler la bannière
			$("header").css("padding-top",bannerMenuHeight);
		}
	}
	if( positionNav !=='hide' && burgerFixed === true && positionHeader === 'hide'){
		// si bannière cachée décalage de la section
		$("section").css("padding-top",bannerMenuHeightSection);
	}
}