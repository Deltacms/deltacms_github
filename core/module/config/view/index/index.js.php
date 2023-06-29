/**
 * This file is part of DeltaCMS.
 */

$( document).ready(function() {

    // Positionnement inital des options
    //-----------------------------------------------------------------------------------------------------

    /**
     * Afficher et masquer options smtp
     */
    if ($("input[name=smtpEnable]").is(':checked')) {
        $("#smtpParam").addClass("disabled");
        $("#smtpParam").slideDown();
    } else {
        $("#smtpParam").removeClass("disabled");
        $("#smtpParam").slideUp();
    }
    /**
     * Afficher et masquer options Auth
     */

    if ($("select[name=smtpAuth]").val() == true) {
        $("#smtpAuthParam").addClass("disabled");
        $("#smtpAuthParam").slideDown();
    } else {
        $("#smtpAuthParam").removeClass("disabled");
        $("#smtpAuthParam").slideUp();
    }

    var configLayout = getCookie("configLayout");
    if (configLayout == null) {
        configLayout = "setup";
        setCookie("configLayout","setup");
    }
    $("#localeContainer").hide();
    $("#socialContainer").hide();
    $("#connectContainer").hide();
    $("#networkContainer").hide();
    $("#setupContainer").hide();
    $("#scriptContainer").hide();	
    $("#" + configLayout + "Container" ).show();
    $("#config" + capitalizeFirstLetter(configLayout) + "Button").addClass("activeButton");


    // Gestion des événements
    //---------------------------------------------------------------------------------------------------------------------

     /**
     * Afficher et masquer options smtp
     */
    $("input[name=smtpEnable]").on("change", function() {
        if ($("input[name=smtpEnable]").is(':checked')) {
            $("#smtpParam").addClass("disabled");
            $("#smtpParam").slideDown();
        } else {
            $("#smtpParam").removeClass("disabled");
            $("#smtpParam").slideUp();
        }
    });

    /**
     * Afficher et masquer options Auth
     */

    $("select[name=smtpAuth]").on("change", function() {
        if ($("select[name=smtpAuth]").val() == true) {
            $("#smtpAuthParam").addClass("disabled");
            $("#smtpAuthParam").slideDown();
        } else {
            $("#smtpAuthParam").removeClass("disabled");
            $("#smtpAuthParam").slideUp();
        }
    });

    /**
     * Options de blocage de connexions
     * Contrôle la cohérence des sélections et interdit une seule valeur Aucune
     */
    $("select[name=connectAttempt]").on("change", function() {
        if ($("select[name=connectAttempt]").val() === "999") {
            $("select[name=connectTimeout]").val(0);
        } else {
            if ($("select[name=connectTimeout]").val() === "0") {
                $("select[name=connectTimeout]").val(300);
            }
        }
    });
    $("select[name=connectTimeout]").on("change", function() {
        if ($("select[name=connectTimeout]").val() === "0") {
            $("select[name=connectAttempt]").val(999);
        } else {
            if ($("select[name=connectAttempt]").val() === "999") {
                $("select[name=connectAttempt]").val(3);
            }
        }
    });

    /**
     * Captcha strong si captcha sélectionné
     */
        $("input[name=connectCaptcha]").on("change", function() {
            
        if ($("input[name=connectCaptcha]").is(':checked')) {
            $("#connectCaptchaStrongWrapper").addClass("disabled");
            $("#connectCaptchaStrongWrapper").slideDown();
            $( "#connectCaptchaStrong" ).prop( "checked", false );
        } else {
            $("#connectCaptchaStrongWrapper").removeClass("disabled");
            $("#connectCaptchaStrongWrapper").slideUp();
        }
    });


    /**
     *  Sélection de la  page de configuration à afficher
     */
    $("#configSetupButton").on("click", function() {
        $("#localeContainer").hide();
        $("#socialContainer").hide();
        $("#connectContainer").hide();
        $("#networkContainer").hide();
		$("#scriptContainer").hide();
        $("#setupContainer").show();
        $("#configSetupButton").addClass("activeButton");
        $("#configLocaleButton").removeClass("activeButton");
        $("#configSocialButton").removeClass("activeButton");
        $("#configConnectButton").removeClass("activeButton");
        $("#configNetworkButton").removeClass("activeButton");
        $("#configScriptButton").removeClass("activeButton");
        setCookie("configLayout","setup");
    });
    $("#configLocaleButton").on("click", function() {
        $("#setupContainer").hide();
        $("#socialContainer").hide();
        $("#connectContainer").hide();
        $("#networkContainer").hide();
		$("#scriptContainer").hide();
        $("#localeContainer").show();
        $("#configSetupButton").removeClass("activeButton");
        $("#configLocaleButton").addClass("activeButton");
        $("#configSocialButton").removeClass("activeButton");
        $("#configConnectButton").removeClass("activeButton");
        $("#configNetworkButton").removeClass("activeButton");
        $("#configScriptButton").removeClass("activeButton");
        setCookie("configLayout","locale");
    });
    $("#configSocialButton").on("click", function() {
        $("#connectContainer").hide();
        $("#setupContainer").hide();
        $("#localeContainer").hide();
        $("#networkContainer").hide();
		$("#scriptContainer").hide();
        $("#socialContainer").show();
        $("#configSetupButton").removeClass("activeButton");
        $("#configLocaleButton").removeClass("activeButton");
        $("#configSocialButton").addClass("activeButton");
        $("#configConnectButton").removeClass("activeButton");
        $("#configNetworkButton").removeClass("activeButton");
        $("#configScriptButton").removeClass("activeButton");
        setCookie("configLayout","social");
    });
    $("#configConnectButton").on("click", function() {
        $("#setupContainer").hide();
        $("#localeContainer").hide();
        $("#socialContainer").hide();
        $("#networkContainer").hide();
		$("#scriptContainer").hide();
        $("#connectContainer").show();
        $("#configSetupButton").removeClass("activeButton");
        $("#configLocaleButton").removeClass("activeButton");
        $("#configSocialButton").removeClass("activeButton");
        $("#configConnectButton").addClass("activeButton");
        $("#configNetworkButton").removeClass("activeButton");
        $("#configScriptButton").removeClass("activeButton");
        setCookie("configLayout","connect");
    });
    $("#configNetworkButton").on("click", function() {
        $("#setupContainer").hide();
        $("#localeContainer").hide();
        $("#socialContainer").hide();
        $("#connectContainer").hide();
		$("#scriptContainer").hide();
        $("#networkContainer").show();
        $("#configSetupButton").removeClass("activeButton");
        $("#configLocaleButton").removeClass("activeButton");
        $("#configSocialButton").removeClass("activeButton");
        $("#configConnectButton").removeClass("activeButton");
        $("#configScriptButton").removeClass("activeButton");
        $("#configNetworkButton").addClass("activeButton");
        setCookie("configLayout","network");
    });
     $("#configScriptButton").on("click", function() {
        $("#setupContainer").hide();
        $("#localeContainer").hide();
        $("#socialContainer").hide();
        $("#connectContainer").hide();
        $("#networkContainer").hide();
		$("#scriptContainer").show();
        $("#configSetupButton").removeClass("activeButton");
        $("#configLocaleButton").removeClass("activeButton");
        $("#configSocialButton").removeClass("activeButton");
        $("#configConnectButton").removeClass("activeButton");
        $("#configNetworkButton").removeClass("activeButton");
		$("#configScriptButton").addClass("activeButton");
        setCookie("configLayout","script");
    }); 

    /**
     * Aspect de la souris
    */
        $("#socialMetaImage, #socialSiteMap, #configBackupCopyButton").click(function(event) {
        $('body, .button').css('cursor', 'wait');
    });


    // Mise en évidence des erreurs de saisie dans les boutons de sélection
    var containers = ["setup", "locale", "social", "connect", "network"];
    $.each( containers, function( index, value ){
        var a = $("div#" + value + "Container").find("input.notice").not(".displayNone");
        if (a.length > 0) {
           $("#config" + capitalizeFirstLetter(value) + "Button").addClass("buttonNotice");
        } else {
           $("#config" + capitalizeFirstLetter(value) + "Button").removeClass("buttonNotice");
        }
    });
	
	// Animation des boutons zwiico-help lien vers la documentation
	var colorButton = <?php echo "'".$this->getData(['admin', 'backgroundColorButtonHelp'])."'"; ?> ;
	var blockButton = <?php echo "'".$this->getData(['admin', 'backgroundBlockColor'])."'"; ?> ;
    $(".helpDisplayButton").mouseenter(function(){
        $(this).css("background-color", colorButton);
    });
    $(".helpDisplayButton").mouseleave(function(){
        $(this).css("background-color", blockButton);
    });
	
	// html vers pdf
	$(".buttontopdf").on("click", function() {
		var doc = new jsPDF();
		var elementHTML = $('#infotopdf').html();
		doc.fromHTML(elementHTML, 15, 15, {
			'width': 170
		});
		doc.save('informations.pdf');
	});
	
});


function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/; samesite=lax";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

// Define function to capitalize the first letter of a string
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Copie dans le presse papier les informations de debug
$("#buttonHtmlToClipboard").on("click", function() {
	var data = "[quote]" + $("#modulesPhp1").text() + "\r\n\r\n";
	data += $("#modulesPhp2").text() + "\r\n\r\n";
	data += $("#directivesFunctionsPhp").text() + "\r\n\r\n";
	data += $("#modulesDeltacms").text() + "[/quote]";
    var infoTextarea = document.createElement("textarea");
    document.body.appendChild(infoTextarea);
    infoTextarea.value = data;
    infoTextarea.select();
    document.execCommand("copy");
    document.body.removeChild(infoTextarea);
});

// Confirmation d'update
$(".configUpdate").on("click", function() {
	var _this = $(this);
	return core.confirm(textConfirm, function() {
		$(location).attr("href", _this.attr("href"));
	});
});

