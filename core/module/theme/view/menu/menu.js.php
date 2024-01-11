/**
 * This file is part of DeltaCMS.
 */

$(document).ready(function(){
	// Menu fixe à afficher
	if($("#themeMenuPosition").val() === 'top') {
		$("#themeMenuPositionFixed").slideDown();
	}
	else {
		$("#themeMenuPositionFixed").slideUp(function() {
			$("#themeMenuFixed").prop("checked", false).trigger("change");
		});
	}

	// Option de menu à afficher
	if($("#themeMenuPosition").val() === 'site-first' || $(this).val() === 'site-second') {
		$("#themeMenuPositionOptions").slideDown();
	}
	else {
		$("#themeMenuPositionOptions").slideUp(function() {
			$("#themeMenuMargin").prop("checked", false).trigger("change");
		});
	}
});


/**
 * Aperçu en direct
 */
$("input, select").on("change", function() {
	var menuFont = $("#themeMenuFont").val();
	var colors = core.colorVariants($("#themeMenuBackgroundColor").val());
	if( $(window).width() >= 800 ){
		// Couleurs du menu en grand écran
		css = "nav,nav.navLevel1 a{background-color:" + colors.normal + "}";
		css += "nav a,#toggle span,nav a:hover{color:" + $("#themeMenuTextColor").val() + "}";
		css += "nav a:hover{background-color:" + colors.darken + "}";
		if ($("#themeMenuActiveColorAuto").is(':checked')) {
			css += "nav a:hover{background-color:" + colors.veryDarken + ";color:" + $('#themeMenuActiveTextColor').val() + ";}";
		} else {
			css += "nav a:hover{background-color:" +  $("#themeMenuActiveColor").val() +  ";color:" + $('#themeMenuActiveTextColor').val() + ";}";
		}
		// sous menu
		var colors = core.colorVariants($("#themeMenuBackgroundColorSub").val());
		css += 'nav .navSub a{background-color:' + colors.normal + '}';
	} else {
		// Couleurs du menu burger
		css = "nav,nav.navLevel1 a{background-color:transparent}"; // fond du menu en grand écran
		css += "nav #toggle{background-color:" + $("#themeMenuBurgerBannerColor").val() + "}"; // bandeau du menu
		css += "nav #toggle span{color:" + $("#themeMenuBurgerIconColor").val() + "}"; // icône burger
		css += "nav #toggle span.delta-ico-menu::before, nav #toggle span.delta-ico-cancel::before{background-color:" + $("#themeMenuBurgerIconBgColor").val() + "}"; // fond icône burger
		css += "nav #menu a, nav #menu a:hover{color:" + $("#themeMenuBurgerTextMenuColor").val() + "}"; // texte du menu
		css += "nav #menu, nav.navMain a{background-color:" + $("#themeMenuBurgerBackgroundColor").val() + "}"; // arrière plan du menu
		css += "nav #menu .navSub a{background-color:" + $("#themeMenuBurgerBackgroundColorSub").val() + "}"; // fond du sous menu
		var colors = core.colorVariants($("#themeMenuBurgerBackgroundColor").val());
		if ($("#themeMenuBurgerActiveColorAuto").is(':checked')) { // fond du menu pour la page active
			css += "nav #menu .active{background-color:" + colors.veryDarken + ";color:" + $('#themeMenuBurgerActiveTextColor').val() + ";}";
		} else {
			css += "nav #menu .active{background-color:" +  $("#themeMenuBurgerActiveColor").val() +  ";color:" + $('#themeMenuBurgerActiveTextColor').val() + ";}";
		}
		css += "nav #burgerText{color:" + $("#themeMenuBurgerTextColor").val() + "}";//Couleur du texte du bandeau
		css += "nav #burgerText{font-size:" + $("#themeMenuBurgerFontSize").val() + "}";// Taille du texte du bandeau
	}

	// Taille, hauteur, épaisseur et capitalisation de caractères du menu
	css += "#toggle span,#menu a{padding:" + $("#themeMenuHeight").val() + ";font-family:'" + menuFont.replace(/\+/g, " ")  + "',sans-serif;font-weight:" + $("#themeMenuFontWeight").val() + ";font-size:" + $("#themeMenuFontSize").val() + ";text-transform:" + $("#themeMenuTextTransform").val() + "}";
	// Alignement du menu
	css += "#menu{text-align:" + $("#themeMenuTextAlign").val() + "}";
	// Marge
	if($("#themeMenuMargin").is(":checked")) {
		if(
			<?php echo json_encode($this->getData(['theme', 'menu', 'position']) === 'site-first'); ?>
			|| <?php echo json_encode($this->getData(['theme', 'menu', 'position']) === 'site-second'); ?>
		) {
			css += 'nav{padding: 10px 10px 0 10px}';
		}
		else {
			css += 'nav{padding:0 10px;}';
		}
	}
	else {
		css += 'nav{margin:0;}';
	}
    if(
		<?php echo json_encode($this->getData(['theme', 'menu', 'position']) === 'top'); ?>
	) {
		css += 'nav{padding:0 10px;}';
	}

	// Position du menu
	switch($("#themeMenuPosition").val()) {
		case 'hide':
			$("nav").show();
			break;
		case 'site-first':
			$("nav").show().prependTo("#site");
			break;
		case 'site-second':
			if(<?php echo json_encode($this->getData(['theme', 'header', 'position']) === 'site'); ?>) {
				$("nav").show().insertAfter("header");
			}
			else {
				$("nav").show().prependTo("#site");
			}
			break;
		case 'body-first':
			$("nav").show().insertAfter("#bar");
			$("#menu").removeClass('container-large');
			$("nav").removeAttr('id');
			$("#menu").addClass('container');
			break;
		case 'body-second':
			if(<?php echo json_encode($this->getData(['theme', 'header', 'position']) === 'body'); ?>) {
				$("nav").show().insertAfter("header");
			}
			else {
				$("nav").show().insertAfter("#bar");
			}
			$("nav").removeAttr('id');
			break;
		case 'top':
			$("nav").show().insertAfter("#bar");
			$("#menu").removeClass('container');
			$("#menu").addClass('container-large');
			$("nav").attr('id','#navfixedconnected');
			break;
		case 'site':
			$("nav").show().prependTo("#site");
			break;
	}

	//  Disposition des items du menu
	if ($("#themeMenuWide").val() === 'none' || $("#themeMenuPosition").val() === 'site-first' || $("#themeMenuPosition").val() === 'site-second') {
		$("#menu").removeClass();
	} else {
		$("#menu").addClass("container");
	}

	//  Largeur du menu quand la bannière est au dessus du site et limitée aus site en grand écran
	if( $(window).width() >= 800 ){
		if( <?php echo json_encode($this->getData(['theme', 'header', 'position']) === 'body'); ?> && <?php echo json_encode($this->getData(['theme', 'header', 'wide']) === 'container'); ?>){
			if( $("#themeMenuPosition").val() === 'body-first' || $("#themeMenuPosition").val() === 'body-second'){
				// Menu avant ou après la bannière
				$("nav").css("width", "<?php echo $this->getData(['theme', 'site', 'width']); ?>");
				$("nav").css("display", "block");
				$("nav").css("margin", "auto");
			} else {
				$("nav").css("width", document.body.clientWidth + 20);
				$("nav").css("max-width", document.body.clientWidth + 20);
				$("body").css("margin", "0px");
			}
		}
	}

	// Visibilité du select 'disposition'
	if( <?php echo json_encode($this->getData(['theme', 'site', 'width']) !== '100%'); ?> && ( $("#themeMenuPosition").val() === 'top' || ( <?php echo json_encode($this->getData(['theme', 'header', 'wide']) === 'none'); ?>
		&& ( $("#themeMenuPosition").val() === 'body-first' || $("#themeMenuPosition").val() === 'body-second')) ) ) {
		$(".themeMenuWideWrapper").show();
	} else {
		$(".themeMenuWideWrapper").hide();
	}

	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
});

// Aperçu pour la largeur minimale des onglets et la largeur du sous-menu
$("#themeMenuMinWidthParentOrAll, #themeMenuMinWidthTab").on("change", function() {
		if( $(window).width() > 799 ){
			if( $('#themeMenuMinWidthParentOrAll').prop('checked') === false){
				$('a.A, a.B').css('min-width', 'auto');
				$.each(parentPage, function(index, value) {
					$('.' + value).css('min-width', $("#themeMenuMinWidthTab").val());
					$('.navsub .'+value).css('width', $('.'+value).css('width'));
					$('.' + value).css('text-align', 'left');
				});
			} else {
					$('a.A, a.B').css('min-width', $("#themeMenuMinWidthTab").val());
					$('nav li ul li a').css('min-width', $("#themeMenuMinWidthTab").val());
					$('nav li ul li a').css('width', $("#themeMenuMinWidthTab").val());
					$('a.A, a.B').css('text-align', 'left');
			}
		}
}).trigger("change");


// Lien de connexion (addClass() et removeClass() au lieu de hide() et show() car ils ne conservent pas le display-inline: block; de #themeMenuLoginLink)
$("#themeMenuLoginLink").on("change", function() {
	if($(this).is(":checked")) {
		$("#menuLoginLink").removeClass('displayNone');
	}
	else {
		$("#menuLoginLink").addClass('displayNone');
	}
}).trigger("change");

// Affiche / Cache les options de la position
$("#themeMenuPosition").on("change", function() {
	if($(this).val() === 'site-first' || $(this).val() === 'site-second') {
		$("#themeMenuPositionOptions").slideDown();
	}
	else {
		$("#themeMenuPositionOptions").slideUp(function() {
			$("#themeMenuMargin").prop("checked", false).trigger("change");
		});
	}
}).trigger("change");

// Affiche / Cache les options du menu fixe
$("#themeMenuPosition").on("change", function() {
	if($(this).val() === 'top') {
		$("#themeMenuPositionFixed").slideDown();
	}
	else {
		$("#themeMenuPositionFixed").slideUp(function() {
			$("#themeMenuFixed").prop("checked", false).trigger("change");
		});
	}
}).trigger("change");

// Affiche la sélection de couleur auto menu grand écran
$("#themeMenuActiveColorAuto").on("change", function() {
	if ($(this).is(':checked') ) {
		$("#themeMenuActiveColorWrapper").slideUp();
	} else {
		$("#themeMenuActiveColorWrapper").slideDown();
	}
}).trigger("change");

// Affiche la sélection de couleur auto menu burger
$("#themeMenuBurgerActiveColorAuto").on("change", function() {
	if ($(this).is(':checked') ) {
		$("#themeMenuBurgerActiveColorWrapper").slideUp();
	} else {
		$("#themeMenuBurgerActiveColorWrapper").slideDown();
	}
}).trigger("change");

// Affiche la sélection de superposition bandeau du menu / bannière
$("#themeMenuBurgerFixed").on("change", function() {
	if ($(this).is(':checked') ) {
		console.log('checked');
		$("#themeMenuBurgerOverlayWrapper").slideDown();
	} else {
		console.log('no checked');
		$("#themeMenuBurgerOverlayWrapper").slideUp();
	}
}).trigger("change");

// Affiche / Cache la sélection des Icones ou du titre pour le menu burger
$("#themeMenuBurgerContent").on("change", function() {
	switch($(this).val()) {
			case 'twoIcon':
				$("#themeMenuBurgerLogoId1").slideDown();
				$("#themeMenuBurgerLogoId2").slideDown();
				$("#themeMenuBurgerTitle").slideUp();
			break;
			case 'oneIcon':
				$("#themeMenuBurgerLogoId1").slideDown();
				$("#themeMenuBurgerLogoId2").slideUp();
				$("#themeMenuBurgerTitle").slideUp();
			break;
			case 'title':
				$("#themeMenuBurgerTitle").slideDown();
				$("#themeMenuBurgerLogoId1").slideUp();
				$("#themeMenuBurgerLogoId2").slideUp();
			break;
			case 'none':
				$("#themeMenuBurgerTitle").slideUp();
				$("#themeMenuBurgerLogoId1").slideUp();
				$("#themeMenuBurgerLogoId2").slideUp();
			break;
	}
}).trigger("select");

/* Décalage de la bannière ou de la section particulier à cette page
* petit écran et menu burger fixe et non caché
*/
if($(window).width() < 800) {
	// Annulation des décalages réalisés par theme.css ou core.js.php
	$("section").css("padding-top","10px");
	$("#site.container header, header.container").css("padding-top","0");
	$(".container").css("max-width","100%");
	$("nav").css("padding","0");
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
