/**
 * This file is part of DeltaCMS.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 * @author Sylvain Lelièvre
 * @copyright 2021 © Sylvain Lelièvre
 * @author Lionel Croquefer
 * @copyright 2022 © Lionel Croquefer
 * @license GNU General Public License, version 3
 * @link https://deltacms.fr/
 * @contact https://deltacms.fr/contact
 *
 * Delta was created from version 11.2.00.24 of ZwiiCMS
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright 2008-2018 © Rémi Jean
 * @author Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright 2018-2021 © Frédéric Tempez
 */

var core = {};

/**
 * Crée un message d'alerte
 */
core.alert = function(text) {
	var lightbox = lity(function($) {
		return $("<div>")
			.addClass("lightbox")
			.append(
				$("<span>").text(text),
				$("<div>")
					.addClass("lightboxButtons")
					.append(
						$("<a>")
							.addClass("button")
							.text("Ok")
							.on("click", function() {
								lightbox.close();
							})
					)
			)
	}(jQuery));
	// Validation de la lightbox avec le bouton entrée
	$(document).on("keyup", function(event) {
		if(event.keyCode === 13) {
			lightbox.close();
		}
	});
	return false;
};

/**
 * Génère des variations d'une couleur
 */
core.colorVariants = function(rgba) {
	rgba = rgba.match(/\(+(.*)\)/);
	rgba = rgba[1].split(", ");
	return {
		"normal": "rgba(" + rgba[0] + "," + rgba[1] + "," + rgba[2] + "," + rgba[3] + ")",
		"darken": "rgba(" + Math.max(0, rgba[0] - 15) + "," + Math.max(0, rgba[1] - 15) + "," + Math.max(0, rgba[2] - 15) + "," + rgba[3] + ")",
		"veryDarken": "rgba(" + Math.max(0, rgba[0] - 20) + "," + Math.max(0, rgba[1] - 20) + "," + Math.max(0, rgba[2] - 20) + "," + rgba[3] + ")",
		//"text": core.relativeLuminanceW3C(rgba) > .22 ? "inherit" : "white"
		"text": core.relativeLuminanceW3C(rgba) > .22 ? "#222" : "#DDD"
	};
};

/**
 * Crée un message de confirmation
 */
core.confirm = function(text, yesCallback, noCallback) {
	var lightbox = lity(function($) {
		return $("<div>")
			.addClass("lightbox")
			.append(
				$("<span>").text(text),
				$("<div>")
					.addClass("lightboxButtons")
					.append(
						$("<a>")
							.addClass("button grey")
							.text(textConfirmNo)
							.on("click", function() {
								lightbox.options('button', true);
								lightbox.close();
								if(typeof noCallback !== "undefined") {
									noCallback();
								}
						}),
						$("<a>")
							.addClass("button")
							.text(textConfirmYes)
							.on("click", function() {
								lightbox.options('button', true);
								lightbox.close();
								if(typeof yesCallback !== "undefined") {
									yesCallback();
								}
						})
					)
			)
	}(jQuery));
	// Callback lors d'un clic sur le fond et sur la croix de fermeture
	lightbox.options('button', false);
	$(document).on('lity:close', function(event, instance) {
		if(
			instance.options('button') === false
			&& typeof noCallback !== "undefined"
		) {
			noCallback();
		}
	});
	// Validation de la lightbox avec le bouton entrée
	$(document).on("keyup", function(event) {
		if(event.keyCode === 13) {
			lightbox.close();
			if(typeof yesCallback !== "undefined") {
				yesCallback();
			}
		}
	});
	return false;
};

/**
 * Scripts à exécuter en dernier
 */
core.end = function() {
	/**
	 * Modifications non enregistrées du formulaire
	 */
	var formDOM = $("form");
	// Ignore :
	// - TinyMCE car il gère lui même le message
	// - Les champs avec data-no-dirty
	var inputsDOM = formDOM.find("input:not([data-no-dirty]), select:not([data-no-dirty]), textarea:not(.editorWysiwyg):not([data-no-dirty])");
	var inputSerialize = inputsDOM.serialize();
	$(window).on("beforeunload", function() {
		if(inputsDOM.serialize() !== inputSerialize) {
			return "Les modifications que vous avez apportées ne seront peut-être pas enregistrées.";
		}
	});
	formDOM.submit(function() {
		$(window).off("beforeunload");
	});
};
$(function() {
	core.end();
});

/**
 * Ajoute une notice
 */
core.noticeAdd = function(id, notice) {
	$("#" + id + "Notice").text(notice).removeClass("displayNone");
	$("#" + id).addClass("notice");
};

/**
 * Supprime une notice
 */
core.noticeRemove = function(id) {
	$("#" + id + "Notice").text("").addClass("displayNone");
	$("#" + id).removeClass("notice");
};

/**
 * Scripts à exécuter en premier
 */
core.start = function() {

	/* Décalage en petit écran de la bannière ou de la section si le menu burger est fixe et non caché
	* dans le cas d'une bannière affichée uniquement en page d'accueil
	*/
	$(window).on("resize", function() {
		if($(window).width() < 800) {
			// Variables du thème
			var positionNav = <?php echo json_encode($this->getData(['theme', 'menu', 'position'])); ?>;
			var burgerFixed = <?php echo json_encode($this->getData(['theme', 'menu', 'burgerFixed'])); ?>;
			var namePage = <?php echo json_encode($this->getUrl(0)); ?>;
			var positionHeader = <?php echo json_encode($this->getData(['theme', 'header', 'position'])); ?>;
			var tinyHidden = <?php echo json_encode($this->getData(['theme', 'header', 'tinyHidden'])); ?>;
			var homePageOnly = <?php echo json_encode($this->getData(['theme', 'header', 'homePageOnly'])); ?>;
			// bannerMenuHeight et bannerMenuHeightSection transmis par core.php / showMenu()
			var burgerOverlay = <?php echo json_encode($this->getData(['theme', 'menu', 'burgerOverlay'])); ?>;
			var homePageId = <?php echo json_encode($this->getData(['locale', 'homePageId'])); ?>;
			if( positionNav !=='hide' && burgerFixed === true && tinyHidden === false && homePageOnly === true){
				var offsetBanner = "0";
				if( burgerOverlay === false) offsetBanner = bannerMenuHeight;
				if( namePage === homePageId ){
					$("#site.container header, header.container").css("padding-top",offsetBanner);
				} else {
					$("section").css("padding-top", bannerMenuHeightSection);
				}
			}
		}
	}).trigger("resize");

  // scroll up and down
  <?php $scrollspeed = $this->getData(['theme', 'site', 'scrollspeed']) ?? 0; ?>
  let toTop = $("#top");
  toTop.on("click", function() {
    $("html, body").animate({scrollTop:0}, <?=$scrollspeed?>, "linear");
  });
  // scroll to bottom
  let toBottom = $("#bottom");
  toBottom.on("click", function() {
    $("html, body").animate({scrollTop:$(document).height()}, <?=$scrollspeed?>, "linear");
  });
  // stop scroll
	$("html, body").bind("scroll mousedown DOMMouseScroll mousewheel keyup", function(){
	$("html, body").stop();
	});

	/**
	 * Affiche / Cache les boutons pour scroller
	 */
	$(window).on("scroll", function() {
		if($(this).scrollTop() > 100) {
			toTop.fadeIn();
			toBottom.fadeIn();
			$("#scrollUaD").fadeIn();
		}
		else {
			toTop.fadeOut();
			toBottom.fadeOut();
			$("#scrollUaD").fadeOut();
		}
	});
	/**
	 * Cache les notifications
	 */
	var notificationTimer;
	$("#notification")
		.on("mouseenter", function() {
			clearTimeout(notificationTimer);
			$("#notificationProgress")
				.stop()
				.width("100%");
		})
		.on("mouseleave", function() {
			// Disparition de la notification
			notificationTimer = setTimeout(function() {
				$("#notification").fadeOut();
			}, 3000);
			// Barre de progression
			$("#notificationProgress").animate({
				"width": "0%"
			}, 3000, "linear");
		})
		.trigger("mouseleave");
	$("#notificationClose").on("click", function() {
		clearTimeout(notificationTimer);
		$("#notification").fadeOut();
		$("#notificationProgress").stop();
	});

	/**
	 * Traitement du formulaire cookies
	 */
	$("#cookieForm").submit(function(event){

		// Varables des cookies
		var samesite = "samesite=lax";
		var getUrl   = window.location;
		var domain   = "domain=" + getUrl.hostname;
		var e = new Date();
		e.setFullYear(e.getFullYear() + 1);
		var expires = "expires=" + e.toUTCString();

		// Crée le cookie d'acceptation Cookies Externes (tiers) si le message n'est pas vide
		var messageCookieExt = "<?php echo $this->getData(['locale', 'cookies', 'cookiesExtText']);?>";
		// le message de consentement des cookies externes est défini en configuration, afficher la checkbox d'acceptation
		if( messageCookieExt.length > 0){
			// Traitement du retour de la checkbox
			if ($("#cookiesExt").is(":checked")) {
				// L'URL du serveur faut TRUE
				document.cookie = "DELTA_COOKIE_EXT_CONSENT=true;" + domain + ";path=/" + ";" + samesite + ";" + expires;
			} else {
				document.cookie = "DELTA_COOKIE_EXT_CONSENT=false;" + domain + ";path=/" + ";" + samesite + ";" + expires;
			}

		}

		// Stocke le cookie d'acceptation
		document.cookie = "DELTA_COOKIE_CONSENT=true;" + domain + ";path=/" + ";" + samesite + ";" + expires;
	});


	/**
	 * Fermeture de la popup des cookies
	 */
	$("#cookieConsent .cookieClose").on("click", function() {
		$('#cookieConsent').addClass("displayNone");
	});

	/**
	 * Commande de gestion des cookies dans le footer
	 */

	 $("#footerLinkCookie").on("click", function() {
		$("#cookieConsent").removeClass("displayNone");
	});

	/**
	 * Animation du panneau des cookies
	 */
	$('#cookieConsent').delay(500).animate({ left: '5%' }, 1500);

	/**
	 * Affiche / Cache le menu en mode responsive
	 */
	 var menuDOM = $("#menu");
	 $("#burgerIcon").on("click", function() {
		 menuDOM.slideToggle();
	 });
	 $(window).on("resize", function() {
		 if($(window).width() > 799) {
			 menuDOM.css("display", "");
		 }
	 });

	/**
	 * Choix de page dans la barre de membre
	 */
	$("#barSelectPage").on("change", function() {
		var pageUrl = $(this).val();
		if(pageUrl) {
			$(location).attr("href", pageUrl);
		}
	});
	/**
	 * Champs d'upload de fichiers
	 */
	// Mise à jour de l'affichage des champs d'upload
	$(".inputFileHidden").on("change", function() {
		var inputFileHiddenDOM = $(this);
		var fileName = inputFileHiddenDOM.val();
		if(fileName === "") {
			fileName = textSelectFile;
			$(inputFileHiddenDOM).addClass("disabled");
		}
		else {
			$(inputFileHiddenDOM).removeClass("disabled");
		}
		inputFileHiddenDOM.parent().find(".inputFileLabel").text(fileName);
	}).trigger("change");
	// Suppression du fichier contenu dans le champ
	$(".inputFileDelete").on("click", function() {
		$(this).parents(".inputWrapper").find(".inputFileHidden").val("").trigger("change");
	});
	// Suppression de la date contenu dans le champ
	$(".inputDateDelete").on("click", function() {
		$(this).parents(".inputWrapper").find(".datepicker").val("").trigger("change");
	});
	// Confirmation de mise à jour
	$("#barUpdate").on("click", function() {
		return core.confirm( textUpdating, function() {
			$(location).attr("href", $("#barUpdate").attr("href"));
		});
	});
	// Confirmation de déconnexion
	$("#barLogout").on("click", function() {
		return core.confirm( textLogout, function() {
			$(location).attr("href", $("#barLogout").attr("href"));
		});
	});
	/**
	 * Bloque la multi-soumission des boutons
	 */
	$("form").on("submit", function() {
		$(this).find(".uniqueSubmission")
			.addClass("disabled")
			.prop("disabled", true)
			.empty()
			.append(
				$("<span>").addClass("delta-ico-spin animate-spin")
			)
	});
	/**
	 * Check adresse email
	 */
	$("[type=email]").on("change", function() {
		var _this = $(this);
		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
		if(pattern.test(_this.val())) {
			core.noticeRemove(_this.attr("id"));
		}
		else {
			core.noticeAdd(_this.attr("id"), textCheckMail);
		}
	});

	/**
	 * Iframes et vidéos responsives
	 */
	var elementDOM = $("iframe, video, embed, object");
	// Calcul du ratio et suppression de la hauteur / largeur des iframes
	elementDOM.each(function() {
		var _this = $(this);
		_this
			.data("ratio", _this.height() / _this.width())
			.data("maxwidth", _this.width())
			.removeAttr("width height");
	});

	// Prend la largeur du parent et détermine la hauteur à l'aide du ratio lors du resize de la fenêtre
	$(window).on("resize", function() {
		elementDOM.each(function() {
			var _this = $(this);
			var width = _this.parent().first().width();
			if (width > _this.data("maxwidth")){ width = _this.data("maxwidth");}
			_this
				.width(width)
				.height(width * _this.data("ratio"));
		});
	}).trigger("resize");

	/*
	* Header responsive
	*/
	$(window).on("resize", function() {
		var responsive = "<?php echo $this->getdata(['theme','header','imageContainer']);?>";
		var feature = "<?php echo $this->getdata(['theme','header','feature']);?>";
		if ( (responsive === "cover" || responsive === "contain") && feature !== "feature" ) {
			var widthpx = "<?php echo $this->getdata(['theme','site','width']);?>";
			var width = widthpx.substr(0,widthpx.length-2);
			var heightpx = "<?php echo $this->getdata(['theme','header','height']);?>";
			var height = heightpx.substr(0,heightpx.length-2);
			var ratio = width / height;
			var feature = "<?php echo $this->getdata(['theme','header','feature']);?>";
			if ( ($(window).width() / ratio) <= height) {
				$("header").height( $(window).width() / ratio );
				$("header").css("line-height", $(window).width() / ratio + "px");
			}
		}
	}).trigger("resize");

	/* Positionnement vertical du bandeau du menu burger si il est fixe et si un utilisateur est connecté
	*/
	$(window).on("resize", function() {
		if($(window).width() < 800) {
			<?php if( $this->getData(['theme','menu', 'burgerFixed'])=== true){ ?>
				var barHeight = $(" #bar ").css("height");
				$(".navfixedburgerconnected").css("top",barHeight);
			<?php } ?>
		}
	}).trigger("resize");

	/* En petit écran, affichage / masquage des items du sous-menu
	* ou signalisation que la page est désactivée par ouverture du sous-menu
	*/
	$(window).on("resize", function() {
		if($(window).width() < 800) {
			function displaySubPages( parentId ){
				var select = "ul#_"+parentId+".navSub";
				var select2 = 'nav #menu ul li #' + parentId + ' span.iconSubExistSmallScreen';
				if( $(select).css("z-index") === "-1" ) {
					$(select).css("z-index","1");
					$(select).css("opacity","1");
					$(select).css("padding-left","20px");
					$(select).css("position","static");
					$(select2).removeClass('delta-ico-plus').addClass('delta-ico-minus');
				} else {
					$(select).css("z-index","-1");
					$(select).css("opacity","0");
					$(select).css("position","absolute");
					$(select2).removeClass('delta-ico-minus').addClass('delta-ico-plus');
				}
			}
			// Affichage du sous-menu si une sous-page est active
			if( typeof parentPage !== "undefined" ){
				$.each(parentPage, function(index, value) {
					var select = "ul#_"+value+".navSub";
					var select2 = 'nav #menu ul li #'+value+' span.iconSubExistSmallScreen';
					var select3 = "ul#_"+value+".navSub > li > a";
					if( $(select3).hasClass("active") ){
							$(select).css("z-index","1");
							$(select).css("opacity","1");
							$(select).css("padding-left","20px");
							$(select).css("position","static");
							$(select2).removeClass('delta-ico-plus').addClass('delta-ico-minus');
					}
				});
			}
			$("nav #menu ul li span").click(function() {
				// id de la page parent
				var parentId = $(this).parents().attr("id");
				displaySubPages( parentId);
			});
			$("nav #menu a.disabled-link").click(function() {
				// id de la page parent
				var parentId = $(this).parents().parents().attr("id");
				displaySubPages( parentId);
			});
		}
	});

	/*
	* Retour en grand écran : annulation du padding-left, de la position static et adaptation du décalage si connecté
	*/
	$(window).on("resize", function() {
		if($(window).width() > 799) {
			$('nav ul li ul').css("position","absolute");
			$('nav ul li ul').css("padding-left","0px");
			var barHeight = $(" #bar ").css("height");
			$("#navfixedconnected").css("top",barHeight);
			$("nav ul li ul").css("opacity", "");
		}
	});

	/*
	* Largeur minimale des onglets principaux du menu et largeur du sous-menu égale à la largeur de l'onglet parent
	* sauf en petit écran
	*/
	$(window).on("resize", function() {
		if( $(window).width() > 799 ){
			if( typeof parentPage !== "undefined" ){
				var page=[];
				if( '<?php echo $this->getData(['theme', 'menu', 'minWidthParentOrAll']); ?>' === ''){
					page = parentPage;
					// suppression d'un sous-menu depuis le dernier enregistrement de theme.css
					$.each(allPage, function(index, value) {
						// si la page n'est pas parent on repositionne min-width à auto
						if( parentPage.includes( value ) === false ) $('nav li .' + value).css('min-width', 'auto');
					});
				} else{
					page = allPage;
				}
				var decalage = 0;
				if(terminalType === 'mobile') decalage = 30;
				$.each(page, function(index, value) {
					$('nav li .' + value).css('min-width', '<?php echo $this->getData(['theme', 'menu', 'minWidthTab']); ?>');
					$('nav li ul li a.' + value).css('width', parseInt($('nav li a.'+value).css('width')) + decalage + 'px');
					$('nav li .' + value).css('text-align', 'left');
				});
			}
		}
	}).trigger("resize");

};


core.start();

/**
 * Confirmation de suppression
 */
$("#pageDelete").on("click", function() {
	var _this = $(this);
	return core.confirm( textPageDelete, function() {
		$(location).attr("href", _this.attr("href"));
	});
});

/**
 * Calcul de la luminance relative d'une couleur
 */
core.relativeLuminanceW3C = function(rgba) {
	// Conversion en sRGB
	var RsRGB = rgba[0] / 255;
	var GsRGB = rgba[1] / 255;
	var BsRGB = rgba[2] / 255;
	// Ajout de la transparence
	var RsRGBA = rgba[3] * RsRGB + (1 - rgba[3]);
	var GsRGBA = rgba[3] * GsRGB + (1 - rgba[3]);
	var BsRGBA = rgba[3] * BsRGB + (1 - rgba[3]);
	// Calcul de la luminance
	var R = (RsRGBA <= .03928) ? RsRGBA / 12.92 : Math.pow((RsRGBA + .055) / 1.055, 2.4);
	var G = (GsRGBA <= .03928) ? GsRGBA / 12.92 : Math.pow((GsRGBA + .055) / 1.055, 2.4);
	var B = (BsRGBA <= .03928) ? BsRGBA / 12.92 : Math.pow((BsRGBA + .055) / 1.055, 2.4);
	return .2126 * R + .7152 * G + .0722 * B;
};

/* Page chargée */
$(document).ready(function(){
	/**
	 * Affiche le sous-menu quand il est sticky
	 */
	$("nav:not(.navsub)").mouseenter(function(){
		$("#navfixedlogout .navSub").css({ 'pointer-events' : 'auto' });
		$("#navfixedconnected .navSub").css({ 'pointer-events' : 'auto' });
	});
	$("nav, .navSub").mouseleave(function(){
		if($(window).width() > 799 ) {
			$("#navfixedlogout .navSub").css({ 'pointer-events' : 'none' });
			$("#navfixedconnected .navSub").css({ 'pointer-events' : 'none' });
		}
	});

	/**
	* Sous-menu en grand écran et terminal mobile
	*/
	$("nav .ico_mobile").click(function() {
		if($(window).width() > 799 ) {
			if( $("nav li:hover ul").css("z-index") !== "8"){
			$("nav li:hover ul").css( {
				"z-index": "8",
				"opacity": "1"
			});
			} else {
			$("nav li:hover ul").css( {
				"z-index": "-1",
				"opacity": "0"
				});
			}
		}
	});

	/**
	* Sous-menu en grand écran et terminal desktop
	*/
	$("nav li").mouseenter(function() {
		if(terminalType === 'desktop' && $(window).width() > 799){
			$("nav li:hover ul").css({
				"z-index": "8",
				"opacity": "1"
			});
		}
	});
	$("nav li").mouseleave(function() {
		if(terminalType === 'desktop' && $(window).width() > 799){
			$("nav li ul").css({
				"z-index": "-1",
				"opacity": "0"
			});
		}
	});

	/**
	 * Chargement paresseux des images et des iframes sauf tinymce
	 */
	$("img,picture,iframe:not([id*='_ifr'])").attr("loading","lazy");

	/**
	 * Effet accordéon
	 */
	$('.accordion').each(function(e) {
		// on stocke l'accordéon dans une variable locale
		var accordion = $(this);
		// on récupère la valeur data-speed si elle existe
		var toggleSpeed = accordion.attr('data-speed') || 100;

		// fonction pour afficher un élément
		function open(item, speed) {
			// on récupère tous les éléments, on enlève l'élément actif de ce résultat, et on les cache
			accordion.find('.accordion-item').not(item).removeClass('active')
				.find('.accordion-content').slideUp(speed);
			// on affiche l'élément actif
			item.addClass('active')
				.find('.accordion-content').slideDown(speed);
		}
		function close(item, speed) {
			accordion.find('.accordion-item').removeClass('active')
				.find('.accordion-content').slideUp(speed);
		}

		// on initialise l'accordéon, sans animation
		open(accordion.find('.active:first'), 0);

		// au clic sur un titre...
		accordion.on('click', '.accordion-title', function(ev) {
			ev.preventDefault();
			// Masquer l'élément déjà actif
			if ($(this).closest('.accordion-item').hasClass('active')) {
				close($(this).closest('.accordion-item'), toggleSpeed);
			} else {
				// ...on lance l'affichage de l'élément, avec animation
				open($(this).closest('.accordion-item'), toggleSpeed);
			}
		});
	});

	/**
	 * Icône du Menu Burger, couleur du bandeau burger et position du menu
	 */
	$("#burgerIcon").click(function() {
		var changeIcon = $('#burgerIcon').children("span");
		var bgColor = "<?php echo $this->getData(['theme', 'menu', 'burgerBannerColor']) ;?>";
		var bgColorOpaque = bgColor.replace(/[^,]+(?=\))/, '1');
		if ( $(changeIcon).hasClass('delta-ico-menu') ) {
			$(changeIcon).removeClass('delta-ico-menu').addClass('delta-ico-cancel');
			$("nav #toggle").css("background-color",bgColorOpaque);
		}
		else {
			$(changeIcon).addClass('delta-ico-menu');
			$("nav #toggle").css("background-color",bgColor);
		};
	});

	/**
	 * Active le système d'aide interne
	 *
	 */

	$(".buttonHelp").click(function() {
			$(".helpDisplayContent").slideToggle();
			/**
			if( $(".buttonHelp").css('opacity') > '0.75'){
				$(".buttonHelp").css('opacity','0.5');
			}
			else{
				$(".buttonHelp").css('opacity','1');
			}
			*/
	});

	$(".helpDisplayContent").click(function() {
		$(".helpDisplayContent").slideToggle();
	});

	/**
	* Remove ID Facebook from URL
	 */
	if(/^\?fbclid=/.test(location.search))
		location.replace(location.href.replace(/\?fbclid.+/, ""));

	/**
	 * No translate Lity close
	 */
	 $(document).on('lity:ready', function(event, instance) {
		$('.lity-close').addClass('notranslate');
	});

	/**
	* Bouton screenshot
	*/
	var dataURL = {};
	$('#screenshot').click(function() {
		html2canvas(document.querySelector("#main_screenshot")).then(canvas => {
			dataURL = canvas.toDataURL('image/jpeg', 0.1);
			$.ajax({
				type: "POST",
				contentType:"application/x-www-form-urlencoded",
				url: "<?php echo helper::baseUrl(false); ?>core/vendor/screenshot/screenshot.php",
				data: {
					image: dataURL
				},
				dataType: "html"
			});
		});
	});

	/* Compteur de liens cliqués
	* Fonctionne avec download_counter.php
	* Les liens comptabilisés doivent avoir la class="clicked_link_count"
	* Envoi au fichier download_counter.php la donnée url
	*/
	<?php if( $this->getData(['config', 'statislite', 'enable']) && is_file('site/data/statislite/module/download_counter/download_counter.php' ) ) { ?>
	  $('.clicked_link_count').on('click', function(event) {
		// Récupérer le chemin vers le fichier
		var filePath = $(this).attr('href');
		// Envoyer une requête AJAX pour enregistrer le téléchargement
		$.ajax({
		  type: 'POST',
		  url: "<?php echo helper::baseUrl(false); ?>site/data/statislite/module/download_counter/download_counter.php",
		  data: {'url': filePath},
		});
	  });
	<?php } ?>

	/*
	* Commentaire de page : affichage du formulaire
	*/
	$("#buttonCommentShowForm").click(function() {
		if( $("#formCommentVisible").css("display") === "none" ){
			$("#formCommentVisible").css("display","block");
		} else {
			$("#formCommentVisible").css("display","none");
		}
	});
	/* Création d'un cookie à l'ouverture de la page formulaire*/
	$(document).ready(function(){
		const d = new Date();
		time = d.getTime();
		document.cookie = "evtO = " +  time  + ";path=/" + ";SameSite=Strict";
	});
	/* Création d'un cookie à la validation de la checkbox 'je ne suis pas un robot'*/
	$( ".commentHumanCheck" ).click(function() {
		const d = new Date();
		time = d.getTime();
		document.cookie = "evtH = " +  time  + ";path=/" + ";SameSite=Strict";
	});
	/* Création d'un cookie quand on arrive sur la checkbox 'je ne suis pas un robot' */
	$( ".commentHumanCheck" ).mouseenter(function() {
		const d = new Date();
		time = d.getTime();
		document.cookie = "evtA = " +  time  + ";path=/" + ";SameSite=Strict";
	});
	/* Création d'un cookie quand on quitte la checkbox 'je ne suis pas un robot' */
	$( ".commentHumanCheck" ).mouseleave(function() {
		const d = new Date();
		time = d.getTime();
		document.cookie = "evtS = " +  time  + ";path=/" + ";SameSite=Strict";
	});
	/* Création d'un cookie à la validation du formulaire */
	$( ".commentHumanBotClose" ).click(function() {
		const d = new Date();
		time = d.getTime();
		document.cookie = "evtV = " +  time  + ";path=/" + ";SameSite=Strict";
	});

	/* Inversion des couleurs du site par chargement dans main.php de theme_invert.css */
	$('.invertColorButton').on('click', function() {
		var cook =  document.cookie.split('; ');
		cook.forEach((item, index) => {
		  if(item ==='DELTA_COOKIE_INVERTCOLOR=true'){
			document.cookie = "DELTA_COOKIE_INVERTCOLOR=false" + ";path=/" + ";SameSite=Strict";
		  }
		  if(item ==='DELTA_COOKIE_INVERTCOLOR=false'){
			document.cookie = "DELTA_COOKIE_INVERTCOLOR=true" + ";path=/" +  ";SameSite=Strict";
		  }
		});
	});

	/* Modification de la taille des caractères */
	$('.increaseFontBtn').on('click', function() {
		var cook =  document.cookie.split('; ');
		cook.forEach((item, index) => {
		  if(item.includes('DELTA_COOKIE_FONTSIZE')){
			var value = parseInt(item.split('=')[1]);
			// incrémenter la valeur du cookie et le mémoriser
			value++;
			if(value > 2 ) value=0;
			document.cookie = "DELTA_COOKIE_FONTSIZE=" + value + ";path=/" +  ";SameSite=Strict";
		  }
		});
	});

	/*
	* Effacement du bouton d'aide avec ? cerclé sur les terminaux mobiles
	*/
	$(window).on("resize", function() {
		if( terminalType === 'mobile'){
			$("span .delta-ico-help").css("display","none");
		}
	}).trigger("resize");

	/*
	* Trust : activités, temps depuis l'ouverture et passés sur une page
	*/
	<?php
	$listMod = ['form'];//Liste des modules supportant la fonction
	if( $this->getData(['config', 'connect', 'trust']) === true && in_array($this->getData(['page', $this->getUrl(0), 'moduleId']),$listMod)) { ?>
		let startTime = Date.now();
		let clicks = 0;
		let mouseMoves = 0;
		let tapCount = 0;
		let touchMoves = 0;
		let scrollActivity = 0;
		let lastScrollTop = 0;

		// Terminal fixe
			document.addEventListener("click", () => clicks++);
			document.addEventListener("mousemove", () => mouseMoves++);
		// Terminal tactile
			document.addEventListener("touchstart", function () { tapCount++; });
			document.addEventListener("touchmove", function () { touchMoves++; });
			window.addEventListener("scroll", function () {
				let scrollTop = window.scrollY || document.documentElement.scrollTop;
				if (Math.abs(scrollTop - lastScrollTop) > 5) {
					scrollActivity++;
				}
				lastScrollTop = scrollTop;
			});

		function updateTrustScore() {
			let timeSpent = (Date.now() - startTime) / 1000;
			fetch("core/vendor/trust/trust.php", {
				method: "POST",
				headers: { "Content-Type": "application/json" },
				body: JSON.stringify({
					time_open: Math.round(startTime/1000),
					time_spent: timeSpent,
					nbClicks: clicks,
					mouseMoves: mouseMoves,
					taps: tapCount,
					touch_moves: touchMoves,
					scrolls: scrollActivity
				}),
			});
		}

		// Mettre à jour toutes les 3 secondes
		setInterval(updateTrustScore, 3000);
		updateTrustScore();
	<?php } ?>

});
