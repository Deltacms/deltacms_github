/**
 * This file is part of DeltaCMS.
 */


/**
 * Confirmation de suppression
 */
$("#pageEditDelete").on("click", function() {
	var _this = $(this);
	return core.confirm( textConfirm, function() {
		$(location).attr("href", _this.attr("href"));
	});
});

$("#pageEditModuleId").on("click", function() {
	protectModule();
});

// Masquage des boutons des commentaires
$("#pageEditCommentEnable").on("change", function() {
	if ($(this).is(':checked') ) {
		$(".pageCommentEnable").slideDown();
	} else {
		$(".pageCommentEnable").slideUp();
	}
}).trigger("change");

function protectModule() {
	var oldModule = $("#pageEditModuleIdOld").val();
	var oldModuleText =  $("#pageEditModuleIdOldText").val();
	var newModule = $("#pageEditModuleId").val();
	if ( oldModule !== "" &&
		 oldModule !== newModule) {
		var _this = $(this);
		core.confirm( text1Confirm + oldModuleText + text2Confirm,
				function() {
					$(location).attr("href", _this.attr("href"));
					return true;
				},
				function() {
					$("#pageEditModuleId").val(oldModule);
					return false;
				}
		);
	}
}

/**
* Paramètres par défaut au chargement
*/
$( document ).ready(function() {

	/*
	* Enleve le menu fixe en édition de page
	*/
	$("nav").removeAttr('id');

	/**
	* Bloque/Débloque le bouton de configuration au changement de module
	* Affiche ou masque la position du module selon le call_user_func
	*/
	if($("#pageEditModuleId").val() === "") {
		/*$("#pageEditModuleConfig").addClass("disabled");
		$("#pageEditContentContainer").hide();*/
	}
	else {
		/*$("#pageEditModuleConfig").removeClass("disabled");
		$("#pageEditContentContainer").hide();*/
		$("#pageEditBlock option[value='bar']").remove();
	}

	/**
	* Masquer et affiche la sélection de position du module
	*/
	if( $("#pageEditModuleId").val() === "redirection" ||
		$("#pageEditModuleId").val() === "" ) {
		$("#configModulePositionWrapper").removeClass("disabled");
		$("#configModulePositionWrapper").slideUp();
	}
	else {
		$("#configModulePositionWrapper").addClass("disabled");
		$("#configModulePositionWrapper").slideDown();
	}


	/**
	* Masquer et démasquer le contenu pour les modules code et redirection
	*/
	if(  $("#pageEditModuleId").val() === "redirection") {
		$("#pageEditContentWrapper").removeClass("disabled");
		$("#pageEditContentWrapper").slideUp();
	} else {
		$("#pageEditContentWrapper").addClass("disabled");
		$("#pageEditContentWrapper").slideDown();
	}
	/**
	* Masquer et démasquer le masquage du titre pour le module redirection
	*/
	if( $("#pageEditModuleId").val() === "redirection" ) {
		$("#pageEditHideTitleWrapper").removeClass("disabled");
		$("#pageEditHideTitleWrapper").hide();
		$("#pageEditBlockLayout").removeClass("disabled");
		$("#pageEditBlockLayout").hide();

	} else {
		$("#pageEditHideTitleWrapper").addClass("disabled");
		$("#pageEditHideTitleWrapper").show();
		$("#pageEditBlockLayout").addClass("disabled");
		$("#pageEditBlockLayout").show();
	}
	/**
	* Masquer et démasquer la sélection des barres
	*/
	switch ($("#pageEditBlock").val()) {
		case "bar":
		case "12":
			$("#pageEditBarLeftWrapper").removeClass("disabled");
			$("#pageEditBarLeftWrapper").slideUp();
			$("#pageEditBarRightWrapper").removeClass("disabled");
			$("#pageEditBarRightWrapper").slideUp();
			break;
		case "3-9":
		case "4-8":
			$("#pageEditBarLeftWrapper").addClass("disabled");
			$("#pageEditBarLeftWrapper").slideDown();
			$("#pageEditBarRightWrapper").removeClass("disabled");
			$("#pageEditBarRightWrapper").slideUp();
			break;
		case "9-3":
		case "8-4":
			$("#pageEditBarLeftWrapper").removeClass("disabled");
			$("#pageEditBarLeftWrapper").slideUp();
			$("#pageEditBarRightWrapper").addClass("disabled");
			$("#pageEditBarRightWrapper").slideDown();
			break;
		case "3-6-3":
		case "2-7-3":
		case "2-8-2":
		case "3-7-2":
			$("#pageEditBarLeftWrapper").addClass("disabled");
			$("#pageEditBarLeftWrapper").slideDown();
			$("#pageEditBarRightWrapper").addClass("disabled");
			$("#pageEditBarRightWrapper").slideDown();
			break;
	};
	if ($("#pageEditBlock").val() === "bar") {
			$("#pageEditMenu").removeClass("disabled");
			$("#pageEditMenu").hide();
			$("#pageEditHideTitleWrapper").removeClass("disabled");
			$("#pageEditHideTitleWrapper").slideUp();
			$("#pageEditbreadCrumbWrapper").removeClass("disabled");
			$("#pageEditbreadCrumbWrapper").slideUp();
			$("#pageEditModuleIdWrapper").removeClass("disabled");
			$("#pageEditModuleIdWrapper").slideUp();
			$("#pageEditModuleConfig").removeClass("disabled");
			$("#pageEditModuleConfig").slideUp();
			$("#pageEditDisplayMenuWrapper").addClass("disabled");
			$("#pageEditDisplayMenuWrapper").slideDown();
			$("#pageTypeMenuWrapper").removeClass("disabled");
			$("#pageTypeMenuWrapper").slideUp();
			$("#pageEditSeoWrapper").removeClass("disabled");
			$("#pageEditSeoWrapper").slideUp();
			$("#pageEditAdvancedWrapper").removeClass("disabled");
			$("#pageEditAdvancedWrapper").slideUp();
			/*
			$("#pageEditBlockLayout").removeClass("col6");
			$("#pageEditBlockLayout").addClass("col12");
			*/
			$(".pageEditCommentRow").css("display","none");

	} else {
			$("#pageEditDisplayMenuWrapper").removeClass("disabled");
			$("#pageEditDisplayMenuWrapper").slideUp();
			$(".pageEditCommentRow").css("display","block");
	}

	/**
	* Masquer ou afficher le chemin de fer
	* Quand le titre est masqué
	*/
	if ($("input[name=pageEditHideTitle]").is(':checked') ||
		  $("#pageEditParentPageId").val() === "" )  {

			$("#pageEditbreadCrumbWrapper").removeClass("disabled");
			$("#pageEditbreadCrumbWrapper").slideUp();
	} else {
		if ($("#pageEditParentPageId").val() !== "") {
			$("#pageEditbreadCrumbWrapper").addClass("disabled");
			$("#pageEditbreadCrumbWrapper").slideDown();
		}
	}

	/**
	* Masquer ou afficher la sélection de l'icône
	*/
	if ($("#pageTypeMenu").val() !== "text") {
		$("#pageIconUrlWrapper").addClass("disabled");
		$("#pageIconUrlWrapper").slideDown();
	} else {
		$("#pageIconUrlWrapper").removeClass("disabled");
		$("#pageIconUrlWrapper").slideUp();
	}

	/**
	* Cache les options de masquage dans les menus quand la page n'est pas affichée.
	*/
	if ($("#pageEditPosition").val() === "0" ) {
			$("#pageEditHideMenuSideWrapper").removeClass("disabled");
			$("#pageEditHideMenuSideWrapper").slideUp();
	} else {
			$("#pageEditHideMenuSideWrapper").addClass("disabled");
			$("#pageEditHideMenuSideWrapper").slideDown();
	}

	/**
	* Cache l'option de masquage des pages enfants
	*/
	if ($("#pageEditParentPageId").val() !== "") {
		  $("#pageEditHideMenuChildrenWrapper").removeClass("disabled");
			$("#pageEditHideMenuChildrenWrapper").slideUp();
		}	else {
			$("#pageEditHideMenuChildrenWrapper").addClass("disabled");
			$("#pageEditHideMenuChildrenWrapper").slideDown();
		}

	/**
	 * Cache le l'option "ne pas afficher les pages enfants dans le menu horizontal" lorsque la page est désactivée
	 */
	if ($("#pageEditDisable").is(':checked') ) {
		$("#pageEditHideMenuChildrenWrapper").removeClass("disabled");
		$("#pageEditHideMenuChildrenWrapper").slideUp();
	} else {
		$("#pageEditHideMenuChildrenWrapper").addClass("disabled");
		$("#pageEditHideMenuChildrenWrapper").slideDown();
	}

	// Animation des boutons delta-ico-help lien vers la documentation
	var colorButton = <?php echo "'".$this->getData(['admin', 'backgroundColorButtonHelp'])."'"; ?> ;
	var blockButton = <?php echo "'".$this->getData(['admin', 'backgroundBlockColor'])."'"; ?> ;
    $(".helpDisplayButton").mouseenter(function(){
        $(this).css("background-color", colorButton);
    });
    $(".helpDisplayButton").mouseleave(function(){
        $(this).css("background-color", blockButton);
    });


});



/**
 * Cache l'option "ne pas afficher les pages enfants dans le menu horizontal" lorsque la page est désactivée
 */
var pageEditDisableDOM = $("#pageEditDisable");
pageEditDisableDOM.on("change", function() {
	if ($(this).is(':checked') ) {
		$("#pageEditHideMenuChildrenWrapper").removeClass("disabled");
		$("#pageEditHideMenuChildrenWrapper").slideUp();
		$("#pageEditHideMenuChildren").prop("checked", false);
	} else {
		$("#pageEditHideMenuChildrenWrapper").addClass("disabled");
		$("#pageEditHideMenuChildrenWrapper").slideDown();
	}
});


/**
* Cache les options de masquage dans les menus quand la page n'est pas affichée.
*/
var pageEditPositionDOM = $("#pageEditPosition");
pageEditPositionDOM.on("change", function() {
	if ($(this).val()  === "0" ) {
		$("#pageEditHideMenuSideWrapper").removeClass("disabled");
		$("#pageEditHideMenuSideWrapper").slideUp();
	} else {
		$("#pageEditHideMenuSideWrapper").addClass("disabled");
		$("#pageEditHideMenuSideWrapper").slideDown();
	}
});

/**
 * Bloque/Débloque le bouton de configuration au changement de module
 * Affiche ou masque la position du module selon le call_user_func
*/
var pageEditModuleIdDOM = $("#pageEditModuleId");
pageEditModuleIdDOM.on("change", function() {
	$("#pageEditModuleConfig").addClass("disabled");
	if($(this).val() === "") {
		/*$("#pageEditModuleConfig").addClass("disabled");*/
		$("#pageEditContentContainer").slideDown();
		$("#pageEditBlock").append('<option value="bar">Barre latérale</option>');
	}
	else {
		/*$("#pageEditModuleConfig").removeClass("disabled");*/
		$("#pageEditContentContainer").slideUp();
		$("#pageEditBlock option[value='bar']").remove();
	}
});

/**
 * Masquer et affiche la sélection de position du module
 *
 * */
var pageEditModuleIdDOM = $("#pageEditModuleId");
pageEditModuleIdDOM.on("change", function() {
	if( $(this).val() === "redirection" ||
		$(this).val() === "") {
		$("#configModulePositionWrapper").removeClass("disabled");
 		$("#configModulePositionWrapper").slideUp();
	}
	else {
		$("#configModulePositionWrapper").addClass("disabled");
		$("#configModulePositionWrapper").slideDown();
	}
});




/**
 * Masquer et démasquer le contenu pour les modules code et redirection
 */
var pageEditModuleIdDOM = $("#pageEditModuleId");
pageEditModuleIdDOM.on("change", function() {
	if( $(this).val() === "redirection") {
		$("#pageEditContentWrapper").removeClass("disabled");
		$("#pageEditContentWrapper").slideUp();
	}
	else {
		$("#pageEditContentWrapper").addClass("disabled");
		$("#pageEditContentWrapper").slideDown();
	}
});



/**
 * Masquer et démasquer le masquage du titre pour le module redirection
 */
var pageEditModuleIdDOM = $("#pageEditModuleId");
pageEditModuleIdDOM.on("change", function() {
	if( $(this).val() === "redirection") {
		$("#pageEditHideTitleWrapper").removeClass("disabled");
		$("#pageEditHideTitleWrapper").slideUp();
		$("#pageEditBlockLayout").removeClass("disabled");
		$("#pageEditBlockLayout").slideUp();
	}
	else {
		$("#pageEditHideTitleWrapper").addClass("disabled");
		$("#pageEditHideTitleWrapper").slideDown();
		$("#pageEditBlockLayout").addClass("disabled");
		$("#pageEditBlockLayout").slideDown();
	}
});


/**
 * Masquer et démasquer la sélection des barres
 */
var pageEditBlockDOM = $("#pageEditBlock");
pageEditBlockDOM.on("change", function() {
	switch ($(this).val()) {
		case "bar":
		case "12":
			$("#pageEditBarLeftWrapper").removeClass("disabled");
			$("#pageEditBarLeftWrapper").slideUp();
			$("#pageEditBarRightWrapper").removeClass("disabled");
			$("#pageEditBarRightWrapper").slideUp();
			break;
		case "3-9":
		case "4-8":
			$("#pageEditBarLeftWrapper").addClass("disabled");
			$("#pageEditBarLeftWrapper").slideDown();
			$("#pageEditBarRightWrapper").removeClass("disabled");
			$("#pageEditBarRightWrapper").slideUp();
			break;
		case "9-3":
		case "8-4":
			$("#pageEditBarLeftWrapper").removeClass("disabled");
			$("#pageEditBarLeftWrapper").slideUp();
			$("#pageEditBarRightWrapper").addClass("disabled");
			$("#pageEditBarRightWrapper").slideDown();
			break;
		case "3-6-3":
		case "2-7-3":
		case "2-8-2":
		case "3-7-2":
			$("#pageEditBarLeftWrapper").addClass("disabled");
			$("#pageEditBarLeftWrapper").slideDown();
			$("#pageEditBarRightWrapper").addClass("disabled");
			$("#pageEditBarRightWrapper").slideDown();
			break;
	}
	if ($(this).val() === "bar") {
			$("#pageEditMenu").removeClass("disabled");
			$("#pageEditMenu").hide();
			$("#pageEditHideTitleWrapper").removeClass("disabled");
			$("#pageEditHideTitleWrapper").slideUp();
			$("#pageTypeMenuWrapper").removeClass("disabled");
			$("#pageTypeMenuWrapper").slideUp();
			$("#pageEditSeoWrapper").removeClass("disabled");
			$("#pageEditSeoWrapper").slideUp();
			$("#pageEditAdvancedWrapper").removeClass("disabled");
			$("#pageEditAdvancedWrapper").slideUp();
			$("#pageEditbreadCrumbWrapper").removeClass("disabled");
			$("#pageEditbreadCrumbWrapper").slideUp();
			$("#pageEditModuleIdWrapper").removeClass("disabled");
			$("#pageEditModuleIdWrapper").slideUp();
			$("#pageEditModuleConfig").removeClass("disabled");
			$("#pageEditModuleConfig").slideUp();
			$("#pageEditDisplayMenuWrapper").addClass("disabled");
			$("#pageEditDisplayMenuWrapper").slideDown();
			/*
			$("#pageEditBlockLayout").removeClass("col6");
			$("#pageEditBlockLayout").addClass("col12");
			*/
			$(".pageEditCommentRow").css("display","none");
	} else {
			$("#pageEditMenu").addClass("disabled");
			$("#pageEditMenu").show();
			$("#pageEditHideTitleWrapper").addClass("disabled");
			$("#pageEditHideTitleWrapper").slideDown();
			$("#pageTypeMenuWrapper").addClass("disabled");
			$("#pageTypeMenuWrapper").slideDown();
			$("#pageEditSeoWrapper").addClass("disabled");
			$("#pageEditSeoWrapper").slideDown();
			$("#pageEditAdvancedWrapper").addClass("disabled");
			$("#pageEditAdvancedWrapper").slideDown();
			$("#pageEditModuleIdWrapper").addClass("disabled");
			$("#pageEditModuleIdWrapper").slideDown();
			$("#pageEditModuleConfig").slideDown();
			$("#pageEditDisplayMenuWrapper").removeClass("disabled");
			$("#pageEditDisplayMenuWrapper").slideUp();
			if ($("#pageEditParentPageId").val() !== "") {
				$("#pageEditbreadCrumbWrapper").addClass("disabled");
				$("#pageEditbreadCrumbWrapper").slideDown();
			}
			if ($("#pageEditModuleId").val() === "") {
				$("#pageEditModuleConfig").addClass("disabled");
			} else {
				$("#pageEditModuleConfig").removeClass("disabled");
			}
			/*
			$("#pageEditBlockLayout").removeClass("col12");
			$("#pageEditBlockLayout").addClass("col6");
			*/
			$(".pageEditCommentRow").css("display","block");
	}
});




/**
 * Masquer ou afficher le chemin de fer
 * Quand le titre est masqué
 */
var pageEditHideTitleDOM = $("#pageEditHideTitle");
pageEditHideTitleDOM.on("change", function() {
	if ($("input[name=pageEditHideTitle]").is(':checked'))  {
			$("#pageEditbreadCrumbWrapper").removeClass("disabled");
			$("#pageEditbreadCrumbWrapper").slideUp();
	} else {
		if ($("#pageEditParentPageId").val() !== "") {
			$("#pageEditbreadCrumbWrapper").addClass("disabled");
			$("#pageEditbreadCrumbWrapper").slideDown();
		}
	}
});


/**
 * Masquer ou afficher le chemin de fer
 * Quand la page n'est pas mère et que le menu n'est pas masqué
 */
var pageEditParentPageIdDOM = $("#pageEditParentPageId");
pageEditParentPageIdDOM.on("change", function() {
	if ($(this).val() === "" &&
		!$('input[name=pageEditHideTitle]').is(':checked') ) {
			$("#pageEditbreadCrumbWrapper").removeClass("disabled");
			$("#pageEditbreadCrumbWrapper").slideUp();
	} else {
			$("#pageEditbreadCrumbWrapper").addClass("disabled");
			$("#pageEditbreadCrumbWrapper").slideDown();

	}
	if ($(this).val() !== "") {
		  $("#pageEditHideMenuChildrenWrapper").removeClass("disabled");
			$("#pageEditHideMenuChildrenWrapper").slideUp();
		}	else {
			$("#pageEditHideMenuChildrenWrapper").addClass("disabled");
			$("#pageEditHideMenuChildrenWrapper").slideDown();
		}
});



/**
 * Masquer ou afficher la sélection de l'icône
 */
var pageTypeMenuDOM = $("#pageTypeMenu");
pageTypeMenuDOM.on("change", function() {
	if ($(this).val() !== "text") {
			$("#pageIconUrlWrapper").addClass("disabled");
			$("#pageIconUrlWrapper").slideDown();
	} else {
			$("#pageIconUrlWrapper").removeClass("disabled");
			$("#pageIconUrlWrapper").slideUp();
	}
});

/**
 * Duplication du champ Title dans Short title
 */
$("#pageEditTitle").on("input", function() {
	$("#pageEditShortTitle").val($(this).val());
});


/**
 * Soumission du formulaire pour éditer le module
 */
$("#pageEditModuleConfig").on("click", function() {
		$("#pageEditModuleRedirect").val(1);
		$("#pageEditForm").trigger("submit");
});

/**
 * Affiche les pages en fonction de la page parent dans le choix de la position
 */
var hierarchy = <?php echo json_encode($this->getHierarchy()); ?>;

var pages = <?php echo json_encode($this->getData(['page'])); ?>;



var positionInitial = <?php echo $this->getData(['page',$this->getUrl(2),"position"]); ?>;

$("#pageEditParentPageId").on("change", function() {
	var positionDOM = $("#pageEditPosition");
	var text1="";
	var text2="";
	var text3="";
	<?php if( $this->getData(['config', 'i18n', 'langAdmin' ]) === 'fr'){
		echo 'text1 = "Ne pas afficher";' ;
		echo 'text2 = "Au début";' ;
		echo 'text3 = "Après \"";' ;
	}
	elseif( $this->getData(['config', 'i18n', 'langAdmin' ]) === 'en'){
		echo 'text1 = "Do not display";' ;
		echo 'text2 = "At the beginning";' ;
		echo 'text3 = "After \"";' ;
	} else {
		echo 'text1 = "No mostrar";' ;
		echo 'text2 = "Al principio";' ;
		echo 'text3 = "Después \"";' ;
	}?>
	positionDOM.empty().append(
		$("<option>").val(0).text(text1),
		$("<option>").val(1).text(text2)
	);
	var parentSelected = $(this).val();
	var positionSelected = 0;
	var positionPrevious = 1;
	// Aucune page parent selectionnée
	if(parentSelected === "") {
		// Liste des pages sans parents
		for(var key in hierarchy) {
			if(hierarchy.hasOwnProperty(key)) {
				// Sélectionne la page avant s'il s'agit de la page courante
				if(key === "<?php echo $this->getUrl(2); ?>") {
					positionSelected = positionPrevious;
				}
				// Sinon ajoute la page à la liste
				else {
					// Enregistre la position de cette page afin de la sélectionner si la prochaine page de la liste est la page courante
					positionPrevious++;
					// Ajout à la liste
					positionDOM.append(
						$("<option>").val(positionPrevious).html(text3 + (pages[key].title) + "\"")
					);
				}
			}
		}
		// 9.0.07 corrige une mauvaise sélection d'une page orpheline avec enfant
		if (positionInitial === 0) {
			positionSelected = 0;
		}
		// 9.0.07
	}
	// Un page parent est selectionnée
	else {
		// Liste des pages enfants de la page parent
		for(var i = 0; i < hierarchy[parentSelected].length; i++) {
			// Pour page courante sélectionne la page précédente (pas de - 1 à positionSelected à cause des options par défaut)
			if(hierarchy[parentSelected][i] === "<?php echo $this->getUrl(2); ?>") {
				positionSelected = positionPrevious;
			}
			// Sinon ajoute la page à la liste
			else {
				// Enregistre la position de cette page afin de la sélectionner si la prochaine page de la liste est la page courante
				positionPrevious++;
				// Ajout à la liste
				positionDOM.append(
					$("<option>").val(positionPrevious).html("Après \"" + (pages[hierarchy[parentSelected][i]].title) + "\"")
				);
			}
		}
	}
	// Sélectionne la bonne position
	positionDOM.val(positionSelected);
}).trigger("change");

/*
* Bouton de configuration des commentaires de page
*/
$("#pageEditCommentConfig").on("click", function() {
	document.cookie = "configLayout" + "=" + ("social" || "")  + "" + "; path=/; samesite=lax";
	console.log( 'cookie écrit');
});

/*
* Masquer démasquer la liste des membres et l'option affichage des fichiers
*/
$("#pageEditGroup").on("change", function() {
	if( $("#pageEditGroup").val() !== "1" ) {
		$("#pageEditMemberWrapper").slideUp();
		$("#pageEditMemberFileEnableWrapper").slideUp();
	}
	else {
		$("#pageEditMemberWrapper").slideDown();
		$("#pageEditMemberFileEnableWrapper").slideDown();
	}
}).trigger("change");

