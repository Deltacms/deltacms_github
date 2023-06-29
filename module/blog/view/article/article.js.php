/**
 * This file is part of DeltaCMS.
 */

/**
 * Affiche le bloc pour rédiger un commentaire
 */
var commentShowDOM = $("#blogArticleCommentShow");
commentShowDOM.on("click focus", function() {
	$("#blogArticleCommentShowWrapper").fadeOut(function() {
		$("#blogArticleCommentWrapper").fadeIn();
		$("#blogArticleCommentContent").trigger("focus");
	});
});

if($("#blogArticleCommentWrapper").find("textarea.notice,input.notice").length) {
	commentShowDOM.trigger("click");
}

/**
 * Cache le bloc pour rédiger un commentaire
 */
$("#blogArticleCommentHide").on("click focus", function() {
	$("#blogArticleCommentWrapper").fadeOut(function() {
		$("#blogArticleCommentShowWrapper").fadeIn();
		$("#blogArticleCommentContent").val("");
		$("#blogArticleCommentAuthor").val("");
	});
});

/**
 * Force le scroll vers les commentaires en cas d'erreur
 */
$("#blogArticleCommentForm").on("submit", function() {
	$(location).attr("href", "#comment");
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

/* Création d'un cookie quand on quitte la checkbox 'je ne suis pas un robot' */
$( ".humanCheck" ).mouseleave(function() {
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtS = " +  time  + ";SameSite=Strict";
});

/* Création d'un cookie quand on arrive sur la checkbox 'je ne suis pas un robot' */
$( ".humanCheck" ).mouseenter(function() {
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtA = " +  time  + ";SameSite=Strict";
});

/* Création d'un cookie à la validation du formulaire */
$( ".humanBotClose" ).click(function() {
	const d = new Date();
	time = d.getTime();
	document.cookie = "evtV = " +  time  + ";SameSite=Strict";
});

/* Affecter la couleur de bordure des blocs à la class blogOuter */
$(document).ready(function(){
	borderColor = "<?php echo $this->getData(['theme', 'block', 'borderColor']); ?>";
	bgColor = "<?php echo $this->getData(['theme', 'site', 'backgroundColor']); ?>";
	$(".blogOuter").css("background-color", bgColor);
	$(".blogOuter").css("border","solid 1px");
	$(".blogOuter").css("border-color", borderColor);
	/* Modifier la couleur au survol */
	$( ".blogOuter" ).mouseenter(function() {
		$(".blogOuter").css("border-radius","5px");
	});
	$( ".blogOuter" ).mouseleave(function() {
		$(".blogOuter").css("border-radius","0px");
	});
});

