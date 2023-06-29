/**
 * This file is part of DeltaCMS.
 */


/**
 * Ajouter ou supprimer une adresse IP masque l'autre case à cocher
 */
$("#statisliteAddIp").on("change", function() {
	if ($(this).is(':checked') ) {
		$(".statisliteSupCheckboxIP").slideUp();
	} else {
		$(".statisliteSupCheckboxIP").slideDown();
	}
});
$("#statisliteSupIp").on("change", function() {
	if ($(this).is(':checked') ) {
		$(".statisliteCheckboxAddIP").slideUp();
	} else {
		$(".statisliteCheckboxAddIP").slideDown();
	}
});

/**
 * Ajouter ou supprimer une page masque l'autre case à cocher
 */
$("#statisliteAddQS").on("change", function() {
	if ($(this).is(':checked') ) {
		$(".statisliteSupCheckboxQS").slideUp();
	} else {
		$(".statisliteSupCheckboxQS").slideDown();
	}
});
$("#statisliteSupQS").on("change", function() {
	if ($(this).is(':checked') ) {
		$(".statisliteCheckboxAddQS").slideUp();
	} else {
		$(".statisliteCheckboxAddQS").slideDown();
	}
});
/**
 * Ajouter ou supprimer un robot
 */
$("#statisliteAddBot").on("change", function() {
	if ($(this).is(':checked') ) {
		$(".statisliteSupCheckboxBot").slideUp();
	} else {
		$(".statisliteSupCheckboxBot").slideDown();
	}
});
$("#statisliteSupBot").on("change", function() {
	if ($(this).is(':checked') ) {
		$(".statisliteCheckboxAddBot").slideUp();
	} else {
		$(".statisliteCheckboxAddBot").slideDown();
	}
});

