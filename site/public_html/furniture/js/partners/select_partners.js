$(document).ready(function () {
    $('.cpf').mask("999.999.999-99");
});

$(".selectPartner").on("click", function() {    
    const arrayPartners = [];
    $('input.partners_id').each(function() {
        if ($(this).is(':checked')) {
            arrayPartners.push($(this).val())
        }
    });

    $.ajax({
        method: "POST",
        url: '<?php printf($GLOBALS["newcompanypartner_url"], $info["companies_id"]) ?>',
        data: {
            btn_save: "yes",
            "no-redirect": "yes",
            partners_id: arrayPartners
        },
        beforeSend: function () {
            $(".spinner-border").show();
        },
        success: function () {
            // setTimeout(function () {
            //     window.location.reload();
            // }, 1000);
        },
        complete: function () {
            $('.spinner-border').hide();
        }
    });
});