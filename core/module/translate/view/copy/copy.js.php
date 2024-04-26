/**
 * Affiche/cache la liste des pages
 */
$('#translateCopyAllPages').on("change", function() {
	if($(this).is(":checked")) {
		$(".pagesList").css("display","none");
		$('.copyAll').css("display","");
	}
	else {
		$(".pagesList").css("display","");
		$('.copyAll').css("display","none");
	}
}).trigger("change");

