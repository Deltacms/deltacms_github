/**
 * This file is part of DeltaCMS.
 */

/**
 * Soumission du formulaire pour enregistrer en brouillon
 */
$("#newsAddDraft").on("click", function() {
	$("#newsAddState").val(0);
	$("#newsAddForm").trigger("submit");
});
