/**
 * This file is part of DeltaCMS.
 */

$( document).ready(function() {

    $("#configBackupForm").submit( function(e){
        //$("#configBackupSubmit").addClass("disabled").prop("disabled", true);
        e.preventDefault();
        var url = "<?php echo helper::baseUrl() . $this->getUrl(0); ?>/backup";
        $.ajax({
            type: "POST",
            url: url,
            data: $("form").serialize(),
            success: function(data){
                $('body, .button').css('cursor', 'default');
                core.alert(text1);
            },
            error: function(data){
                $('body, .button').css('cursor', 'default');
                core.alert(text2);
            },
            complete: function(){
                $("#configBackupSubmit").removeClass("disabled").prop("disabled", false);
                $("#configBackupSubmit").removeClass("uniqueSubmission").prop("uniqueSubmission", false);
                $("#configBackupSubmit span").removeClass("delta-ico-spin animate-spin");
                $("#configBackupSubmit span").addClass("delta-ico-check delta-ico-margin-right").text("Sauvegarder");
            }
        });
    });


    /**
     * Confirmation de sauvegarde complète
     */
    $("#configBackupSubmit").on("click", function() {
        if ($("input[name=configBackupOption]").is(':checked')) {
            return core.confirm(text3, function() {
                //$(location).attr("href", _this.attr("href"));
                $('body, .button').css('cursor', 'wait');
                $('form#configBackupForm').submit();
            });
        }
    });

});

