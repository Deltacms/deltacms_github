/**
 * This file is part of DeltaCMS.
 */
 
$( "#formFileReset" ).click(function() {
	$( "#fileToUpload" ).val('');
});

/* Création et mise à jour du cookie sur modification d'un input */
$( ".humanBot" ).mouseleave(function() {
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtC = " +  time  + ";SameSite=Strict";
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

/* Affecter la couleur de bordure des blocs aux class formOuter et formInputFile */
$(document).ready(function(){
	borderColor = "<?php echo $this->getData(['theme', 'block', 'borderColor']); ?>";
	bgColor = "<?php echo $this->getData(['theme', 'site', 'backgroundColor']); ?>";
	$(".formInputFile").css("border-color", borderColor);
	$(".formOuter").css("background-color", bgColor);
	$(".formOuter").css("border","solid 1px");
	$(".formOuter").css("border-color", borderColor);
	/* Modifier la couleur au survol */
	$( ".formOuter" ).mouseenter(function() {
		$(".formOuter").css("border-radius","5px");
	});
	$( ".formOuter" ).mouseleave(function() {
		$(".formOuter").css("border-radius","0px");
	});
});

