
/**
 * This file is part of DeltaCMS.
 */

/**
 * Affichage de l'id en simulant FILTER_ID
 */
$("#installId").on("change keydown keyup", function(event) {
	var userId = $(this).val();
	if(
		event.keyCode !== 8 // BACKSPACE
		&& event.keyCode !== 37 // LEFT
		&& event.keyCode !== 39 // RIGHT
		&& event.keyCode !== 46 // DELETE
		&& window.getSelection().toString() !== userId // Texte sélectionné
	) {
		var searchReplace = {
			"á": "a", "à": "a", "â": "a", "ä": "a", "ã": "a", "å": "a", "ç": "c", "é": "e", "è": "e", "ê": "e", "ë": "e", "í": "i", "ì": "i", "î": "i", "ï": "i", "ñ": "n", "ó": "o", "ò": "o", "ô": "o", "ö": "o", "õ": "o", "ú": "u", "ù": "u", "û": "u", "ü": "u", "ý": "y", "ÿ": "y",
			"Á": "A", "À": "A", "Â": "A", "Ä": "A", "Ã": "A", "Å": "A", "Ç": "C", "É": "E", "È": "E", "Ê": "E", "Ë": "E", "Í": "I", "Ì": "I", "Î": "I", "Ï": "I", "Ñ": "N", "Ó": "O", "Ò": "O", "Ô": "O", "Ö": "O", "Õ": "O", "Ú": "U", "Ù": "U", "Û": "U", "Ü": "U", "Ý": "Y", "Ÿ": "Y",
			"'": "-", "\"": "-", " ": "-"
		};
		userId = userId.replace(/[áàâäãåçéèêëíìîïñóòôöõúùûüýÿ'" ]/ig, function(match) {
			return searchReplace[match];
		});
		userId = userId.replace(/[^a-z0-9-]/ig, "");
		$(this).val(userId);
	}
});

/*
 * Affichage des labels français espagnols ou anglais
*/

$("#installLang").change( function(e) {	
	if( $("#installLang").val() === 'en'){
		//English
		for (var i = 1; i < 13; i++) {
			$("#m"+i+"f").hide();
			$("#m"+i+"s").hide();
			$("#m"+i+"e").show();
		}
	} else if( $("#installLang").val() === 'fr'){
		//Français
		for (var i = 1; i < 13; i++) {
			$("#m"+i+"e").hide();
			$("#m"+i+"s").hide();
			$("#m"+i+"f").show();
		}
	} else {
		//Espagnol
		for (var i = 1; i < 13; i++) {
			$("#m"+i+"f").hide();
			$("#m"+i+"e").hide();
			$("#m"+i+"s").show();
		}
	}
	updateCheckboxThank();
	updateCheckboxDefaultData();
}).trigger("change");

function updateCheckboxThank() {
	const messages = {
		fr: 'Merci Deltacms',
		en: 'Thank you Deltacms',
		es: 'Gracias Deltacms'
	};
	const helps = {
		fr: 'Si la case est cochée un courriel sera envoyé à Deltacms à des fins statistiques. Il contiendra uniquement l\'adresse de votre site.',
		en: 'If the box is checked, an email will be sent to Deltacms for statistical purposes. It will contain only your website address.',
		es: 'Si marca la casilla, se enviará un correo electrónico a Deltacms con fines estadísticos. Este correo solo contendrá la dirección de su sitio web.'
	};
	const el = $('#installThank').next('label').find('.helpButton')[0];
	$('#installThank').next('label').children('span').first().text(messages[$('#installLang').val()]);
	if (el._tippy) {
		el._tippy.setContent(helps[$('#installLang').val()]);
	}
}

function updateCheckboxDefaultData() {
	const messages = {
		fr: 'Sans exemple de site',
		en: 'Without an example site',
		es: 'Sin ejemplo de sitio'
	};
	$('#installDefaultData').next('label').children('span').first().text(messages[$('#installLang').val()]);

}
