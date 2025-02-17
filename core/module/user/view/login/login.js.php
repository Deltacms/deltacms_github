/**
 * This file is part of DeltaCMS.
 */

$(document).ready(function(){
	
	// Visibilité du mot de passe
	// Gestion pour appareils tactiles
	if ("ontouchstart" in document.documentElement) {
	$(".delta-ico-eye").on("touchstart", function () {
	  $("#userLoginPassword").attr("type", "text");
	});
	$(".delta-ico-eye").on("touchend touchcancel", function () {
	  setTimeout(function () {
		$("#userLoginPassword").attr("type", "password");
	  }, 100);
	});
	} else {
	// Gestion pour appareils avec souris
	$(".delta-ico-eye").hover(
	  function () {
		$("#userLoginPassword").attr("type", "text");
	  },
	  function () {
		$("#userLoginPassword").attr("type", "password");
	  }
	);
	}


	// Affecter la couleur de bordure des blocs ou du fond à la class formOuter
	borderColor = "<?php echo $this->getData(['theme', 'block', 'borderColor']); ?>";
	bgColor = "<?php echo $this->getData(['theme', 'site', 'backgroundColor']); ?>";
	$(".userOuter").css("background-color", bgColor);
	$(".userOuter").css("border","solid 1px");
	$(".userOuter").css("border-color", borderColor);
	
	// Modifier la couleur au survol
	$( ".userOuter" ).mouseenter(function() {
		$(".userOuter").css("border-radius","5px");
	});
	$( ".userOuter" ).mouseleave(function() {
		$(".userOuter").css("border-radius","0px");
	});
});

