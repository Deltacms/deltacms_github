/**
 * This file is part of DeltaCMS.
 */

/**
 * Soumission du formulaire pour enregistrer en brouillon
 */
$("#blogAddDraft").on("click", function() {
	$("#blogAddState").val(0);
	$("#blogAddForm").trigger("submit");
});

/**
 * Options de commentaires
 */
$("#blogAddCommentClose").on("change", function() {
	if ($(this).is(':checked') ) {
		$(".commentOptionsWrapper").slideUp();
	} else {
		$(".commentOptionsWrapper").slideDown();
	}
});

$("#blogAddCommentNotification").on("change", function() {
	if ($(this).is(':checked') ) {
		$("#blogAddCommentGroupNotification").slideDown();
	} else {
		$("#blogAddCommentGroupNotification").slideUp();
	}
});


$( document).ready(function() {

	if ($("#blogAddCloseComment").is(':checked') ) {
		$(".commentOptionsWrapper").slideUp();
	} else {
		$(".commentOptionsWrapper").slideDown();
	}

	if ($("#blogAddCommentNotification").is(':checked') ) {
		$("#blogAddCommentGroupNotification").slideDown();
	} else {
		$("#blogAddCommentGroupNotification").slideUp();
	}
});