/**
 * Initialisation du sélecteur de date
 */
if ( typeof(lang_flatpickr) == 'undefined') {
	var lang_flatpickr = "default";
};
$(function() {
	$(".datepicker").flatpickr({
		altInput: true,
		altFormat: "d/m/Y H:i",
		enableTime: true,
		time_24hr: true,
		locale: lang_flatpickr,
		regional: lang_flatpickr,	
		dateFormat: "Y-m-d H:i:s"
	});
});
