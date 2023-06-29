/**
 * This file is part of DeltaCMS.
 */

/**
 * Soumission du formulaire pour enregistrer en brouillon
 */
$("#newsEditDraft").on("click", function() {
	$("#newsEditState").val(0);
	$("#newsEditForm").trigger("submit");
});