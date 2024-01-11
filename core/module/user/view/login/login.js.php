/**
 * This file is part of DeltaCMS.
 */

/* Visibilité du mot de passe */
$(".delta-ico-eye").mouseenter(function() {
	$("#userLoginPassword").attr("type","text");
});
$(".delta-ico-eye").mouseleave(function() {
	$("#userLoginPassword").attr("type","password");
});

/* Création et mise à jour du cookie sur modification d'un input */
$( ".humanBot" ).mouseleave(function() {
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtC = " +  time  + ";SameSite=Strict";
});

/* Cookie supplémentaire pour autoremplissage des champs */
$( ".humanBot" ).change(function() {
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtX = " +  time  + ";SameSite=Strict";
});

/* Création d'un cookie à l'ouverture de la page formulaire*/
$(document).ready(function(){
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtO = " +  time  + ";SameSite=Strict";
});

/* Création d'un cookie à la validation de la checkbox 'je ne suis pas un robot'*/
$( ".humanCheck" ).click(function() {
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtH = " +  time  + ";SameSite=Strict";
});

/* Création d'un cookie quand on arrive sur la checkbox 'je ne suis pas un robot' */
$( ".humanCheck" ).mouseenter(function() {
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtA = " +  time  + ";SameSite=Strict";
});

/* Création d'un cookie quand on quitte la checkbox 'je ne suis pas un robot' */
$( ".humanCheck" ).mouseleave(function() {
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtS = " +  time  + ";SameSite=Strict";
});

/* Création d'un cookie à la validation du formulaire */
$( ".humanBotClose" ).click(function() {
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtV = " +  time  + ";SameSite=Strict";
});

/* Affecter la couleur de bordure des blocs ou du fond à la class formOuter */
$(document).ready(function(){
	borderColor = "<?php echo $this->getData(['theme', 'block', 'borderColor']); ?>";
	bgColor = "<?php echo $this->getData(['theme', 'site', 'backgroundColor']); ?>";
	$(".userOuter").css("background-color", bgColor);
	$(".userOuter").css("border","solid 1px");
	$(".userOuter").css("border-color", borderColor);
	/* Modifier la couleur au survol */
	$( ".userOuter" ).mouseenter(function() {
		$(".userOuter").css("border-radius","5px");
	});
	$( ".userOuter" ).mouseleave(function() {
		$(".userOuter").css("border-radius","0px");
	});
});
