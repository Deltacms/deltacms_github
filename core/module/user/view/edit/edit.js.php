/**
 * This file is part of DeltaCMS.
 */

/**
 * Droits des groupes
 */
$("#userEditGroup").on("change", function() {
	$(".userEditGroupDescription").hide();
	$("#userEditGroupDescription" + $(this).val()).show();
	if ($("#userEditGroup option:selected").val() < 0) {
		$("#userEditLabelAuth").css("display","none");
	} else {
		$("#userEditLabelAuth").css("display","inline-block");
	}
}).trigger("change");

$(document).ready(function(){
	// Membre avec ou sans gestion de fichiers
	if($("#userEditGroup").val() === '1') {
		$("#userEditMemberFiles").slideDown();
	}
	else {
		$("#userEditMemberFiles").slideUp(function() {
			$("#userEditFiles").prop("checked", false).trigger("change");
		});
	}
});

$("#userEditGroup").on("change", function() {
	// Membre avec ou sans gestion de fichiers
	if($("#userEditGroup").val() === '1') {
		$("#userEditMemberFiles").slideDown();
	}
	else {
		$("#userEditMemberFiles").slideUp(function() {
			$("#userEditFiles").prop("checked", false).trigger("change");
		});
	}
}).trigger("change");
