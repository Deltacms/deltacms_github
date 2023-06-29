/**
 * This file is part of DeltaCMS.
 */


// Lien de connexion
$("#blogEditMailNotification").on("change", function() {
	if($(this).is(":checked")) {
		$("#formConfigGroup").show();
	}
	else {
		$("#formConfigGroup").hide();
	}
}).trigger("change");


/**
 * Soumission du formulaire pour enregistrer en brouillon
 */
$("#blogEditDraft").on("click", function() {
	$("#blogEditState").val(0);
	$("#blogEditForm").trigger("submit");
});

/**
 * Options de commentaires
 */
$("#blogEditCommentClose").on("change", function() {
	if ($(this).is(':checked') ) {
		$(".commentOptionsWrapper").slideUp();
	} else {
		$(".commentOptionsWrapper").slideDown();
	}
});

$("#blogEditCommentNotification").on("change", function() {
	if ($(this).is(':checked') ) {
		$("#blogEditCommentGroupNotification").slideDown();
	} else {
		$("#blogEditCommentGroupNotification").slideUp();
	}
});


$( document).ready(function() {

	if ($("#blogEditCloseComment").is(':checked') ) {
		$(".commentOptionsWrapper").slideUp();
	} else {
		$(".commentOptionsWrapper").slideDown();
	}

	if ($("#blogEditCommentNotification").is(':checked') ) {
		$("#blogEditCommentGroupNotification").slideDown();
	} else {
		$("#blogEditCommentGroupNotification").slideUp();
	}
});