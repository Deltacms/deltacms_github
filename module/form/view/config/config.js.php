/**
 * This file is part of DeltaCMS.
 */
 
/**
 * Ajout d'un champ
 */
function add(inputUid, input) {
	// Nouveau champ
	var newInput = $($("#formConfigCopy").html());
	// Ajout de l'ID unique aux champs
	newInput.find("a, input, select").each(function() {
		var _this = $(this);
		_this.attr({
			id: _this.attr("id").replace("[]", "[" + inputUid + "]"),
			// name obsolète remplacé par id
			name: _this.attr("id").replace("[]", "[" + inputUid + "]")
		});
	});
	newInput.find("label").each(function() {
		var _this = $(this);
		_this.attr("for", _this.attr("for").replace("[]", "[" + inputUid + "]"));
	});
	// Attribue les bonnes valeurs
	if(input) {
		// Nom du champ
		newInput.find("[name='formConfigName[" + inputUid + "]']").val(input.name);
		// Type de champ
		newInput.find("[name='formConfigType[" + inputUid + "]']").val(input.type);
		// Largeur du champ
		newInput.find("[name='formConfigWidth[" + inputUid + "]']").val(input.width);
		// Valeurs du champ
		newInput.find("[name='formConfigValues[" + inputUid + "]']").val(input.values);
		// Champ obligatoire
		newInput.find("[name='formConfigRequired[" + inputUid + "]']").prop("checked", input.required);
	}
	// Ajout du nouveau champ au DOM
	$("#formConfigInputs")
		.append(newInput.hide())
		.find(".formConfigInput").last().show();
	// Cache le texte d'absence de champ
	$("#formConfigNoInput:visible").hide();
	// Check le type
	$(".formConfigType").trigger("change");
	// Actualise les positions
	position();
}

/**
 * Calcul des positions
 */
function position() {
	$("#formConfigInputs").find(".formConfigPosition").each(function(i) {
		$(this).val(i + 1);
	});
}

/**
 * Ajout des champs déjà existant
 */
var inputUid = 0;
var inputs = <?php echo json_encode($this->getData(['module', $this->getUrl(0), 'input'])); ?>;
if(inputs) {
	var inputsPerPosition = <?php echo json_encode(helper::arrayCollumn($this->getData(['module', $this->getUrl(0), 'input']), 'position', 'SORT_ASC')); ?>;
	$.each(inputsPerPosition, function(id) {
		add(inputUid, inputs[id]);
		inputUid++;
	});
}

/**
 * Afficher/cacher les options supplémentaires
 */
$(document).on("click", ".formConfigMoreToggle", function() {

	$(this).parents(".formConfigInput").find(".formConfigMore").slideToggle();
	$(this).parents(".formConfigInput").find(".formConfigMoreLabel").slideToggle();
});

/**
 * Crée un nouveau champ à partir des champs cachés
 */
$("#formConfigAdd").on("click", function() {
	add(inputUid);
	inputUid++;
});

/**
 * Actions sur les champs
 */
// Tri entre les champs
sortable("#formConfigInputs", {
	forcePlaceholderSize: true,
	containment: "#formConfigInputs",
	handle: ".formConfigMove"
});
$("#formConfigInputs")
	// Actualise les positions
	.on("sortupdate", function() {
		position();
	})
	// Suppression du champ
	.on("click", ".formConfigDelete", function() {
		var inputDOM = $(this).parents(".formConfigInput");
		// Cache le champ
		inputDOM.hide();
		// Supprime le champ
		inputDOM.remove();
		// Affiche le texte d'absence de champ
		if($("#formConfigInputs").find(".formConfigInput").length === 0) {
			$("#formConfigNoInput").show();
		}
		// Actualise les positions
		position();
	})
	// Affiche/cache le champ "Valeurs" en fonction des champs cachés
	.on("change", ".formConfigType", function() {
		var _this = $(this);
		switch (_this.val()) {
			case "select":
				_this.parents(".formConfigInput").find("label[for*=formConfigRequired]").show();
				_this.parents(".formConfigInput").find(".formConfigValuesWrapper").slideDown();
				_this.parents(".formConfigInput").find(".formConfigLabelWrapper").slideUp();
				break;
			case  "label":
				_this.parents(".formConfigInput").find("label[for*=formConfigRequired]").hide();
				_this.parents(".formConfigInput").find(".formConfigLabelWrapper").slideDown();
				_this.parents(".formConfigInput").find(".formConfigValuesWrapper").slideUp();
				break;
			case  "file":
				_this.parents(".formConfigInput").find("label[for*=formConfigRequired]").hide();
				_this.parents(".formConfigInput").find(".formConfigLabelWrapper").slideDown();
				_this.parents(".formConfigInput").find(".formConfigValuesWrapper").slideUp();
				break;
			case  "checkbox":
				_this.parents(".formConfigInput").find("label[for*=formConfigRequired]").hide();
				_this.parents(".formConfigInput").find(".formConfigLabelWrapper").slideDown();
				_this.parents(".formConfigInput").find(".formConfigValuesWrapper").slideUp();
				break;
			default:
				_this.parents(".formConfigInput").find("label[for*=formConfigRequired]").show();
				_this.parents(".formConfigInput").find(".formConfigValuesWrapper").slideUp();
				_this.parents(".formConfigInput").find(".formConfigLabelWrapper").slideUp();
		}
	});
// Simule un changement de type au chargement de la page
$(".formConfigType").trigger("change");

/**
 * Affiche/cache les options de la case à cocher du mail
 */
$("#formConfigMailOptionsToggle").on("change", function() {
	if($(this).is(":checked")) {
		$("#formConfigMailOptions").slideDown();
	}
	else {
		$("#formConfigMailOptions").slideUp(function() {
			$("#formConfigGroup").val("");
			$("#formConfigSubject").val("");
			$("#formConfigMail").val("");
			$("#formConfigUser").val("");
		});
	}
}).trigger("change");

/**
 * Affiche/cache les options de la case à cocher de la redirection
 */
$("#formConfigPageIdToggle").on("change", function() {
	if($(this).is(":checked")) {
		$("#formConfigPageIdWrapper").slideDown();
	}
	else {
		$("#formConfigPageIdWrapper").slideUp(function() {
			$("#formConfigPageId").val("");
		});
	}
}).trigger("change");

/**
* Paramètres par défaut au chargement
*/
$( document ).ready(function() {

	/**
	* Masquer ou afficher la sélection du logo
	*/
	if ($("#formConfigSignature").val() !== "text") {
		$("#formConfigLogoWrapper").addClass("disabled");
		$("#formConfigLogoWrapper").slideDown();
		$("#formConfigLogoWidthWrapper").addClass("disabled");
		$("#formConfigLogoWidthWrapper").slideDown();
	} else {
		$("#formConfigLogoWrapper").removeClass("disabled");
		$("#formConfigLogoWrapper").slideUp();
		$("#formConfigLogoWidthWrapper").removeClass("disabled");
		$("#formConfigLogoWidthWrapper").slideUp();
	}
});

/**
 * Masquer ou afficher la sélection du logo
 */
var formConfigSignatureDOM = $("#formConfigSignature");
formConfigSignatureDOM.on("change", function() {
	if ($(this).val() !== "text") {
			$("#formConfigLogoWrapper").addClass("disabled");
			$("#formConfigLogoWrapper").slideDown();
			$("#formConfigLogoWidthWrapper").addClass("disabled");
			$("#formConfigLogoWidthWrapper").slideDown();
	} else {
			$("#formConfigLogoWrapper").removeClass("disabled");
			$("#formConfigLogoWrapper").slideUp();
			$("#formConfigLogoWidthWrapper").removeClass("disabled");
			$("#formConfigLogoWidthWrapper").slideUp();
	}
});
