$(document).ready(function () {

    $('body').keypress(function (event) {
        if (event.keyCode == '13') {
            return false;
        }
    });

    $('.cpf').mask("999.999.999-99");
    $('.cnpj').mask("99.999.999/9999-99");
    $('.phone').mask("(99) 9999-9999");
    $('.postalcode').mask("99999-999");

    $(".first_name_search").autocomplete({
        serviceUrl: '<?php print($GLOBALS["partners_url"]) ?>.autocomplete?autcomplete_field=name',
        autoFocus: true,
        minChars: 3,
        deferRequestBy: 5,
        noCache: true,
        onSelect: function (sugestion) {
            $("#partners_id").val(sugestion.data.idx);
            $("#partners_first_name").val(sugestion.data.last_name == null ? sugestion.data.first_name : sugestion.data.first_name + " " + sugestion.data.last_name);
            $("#partners_cpf").val(sugestion.data.document);
            $("#partners_mail").val(sugestion.data.mail);

            $(".mail_search").val(sugestion.data.mail);
            $(".first_name_search").val(sugestion.data.last_name == null ? sugestion.data.first_name : sugestion.data.first_name + " " + sugestion.data.last_name);
            $(".document_search").val(sugestion.data.document);
        }
    });

    $(".document_search").autocomplete({
        serviceUrl: '<?php print($GLOBALS["partners_url"]) ?>.autocomplete?autcomplete_field=cpf',
        autoFocus: true,
        minChars: 3,
        deferRequestBy: 5,
        noCache: true,
        onSelect: function (sugestion) {
            $("#partners_id").val(sugestion.data.idx);
            $("#partners_first_name").val(sugestion.data.last_name == null ? sugestion.data.first_name : sugestion.data.first_name + " " + sugestion.data.last_name);
            $("#partners_cpf").val(sugestion.data.document);
            $("#partners_mail").val(sugestion.data.mail);

            $(".mail_search").val(sugestion.data.mail);
            $(".first_name_search").val(sugestion.data.last_name == null ? sugestion.data.first_name : sugestion.data.first_name + " " + sugestion.data.last_name);
            $(".document_search").val(sugestion.data.document);
        }
    });

    $(".partners_mail_search").autocomplete({
        serviceUrl: '<?php print($GLOBALS["partners_url"]) ?>.autocomplete?autcomplete_field=mail',
        autoFocus: true,
        minChars: 3,
        deferRequestBy: 5,
        noCache: true,
        onSelect: function (sugestion) {
            $("#partners_id").val(sugestion.data.idx);
            $("#partners_first_name").val(sugestion.data.last_name == null ? sugestion.data.first_name : sugestion.data.first_name + " " + sugestion.data.last_name);
            $("#partners_cpf").val(sugestion.data.document);
            $("#partners_mail").val(sugestion.data.mail);

            $(".mail_search").val(sugestion.data.mail);
            $(".first_name_search").val(sugestion.data.last_name == null ? sugestion.data.first_name : sugestion.data.first_name + " " + sugestion.data.last_name);
            $(".document_search").val(sugestion.data.document);
        }
    });
});

function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('address').value = ("");
    document.getElementById('district').value = ("");
    document.getElementById('city').value = ("");
    document.getElementById('uf').value = ("");
}

/* Consulta CEP */
$(".postalcode").change(function () {

    //Nova variável "cep" somente com dígitos.
    var cep = $(this).val().replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#address").val("...");
            $("#district").val("...");
            $("#city").val("...");
            $("#uf").val("...");

            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#address").val(dados.logradouro);
                    $("#district").val(dados.bairro);
                    $("#city").val(dados.localidade);
                    $("#uf").val(dados.uf);
                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    limpa_formulário_cep();
                    alert("CEP não encontrado.");
                }
            });
        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
});

/* Consultar CPF */
$("#document_partner").change(function () {
    var cpf = $(this).val().replace(/\D/g, '');

    $.ajax({
        method: "POST",
        url: '/consultar_socio',
        data: {
            cpf: cpf
        },
        beforeSend: function () {
            $(".spinner-border").show();
        },
        success: function (data) {
            var jsonData = JSON.parse(data);
            if (jsonData.error == true) {
                $("#error_cpf").removeClass("d-none").html('<span>' + jsonData.message + '</span>').css("color", "red");
                $("#btn_save").addClass("d-none");
            } else {
                $("#error_cpf").addClass("d-none");
                $("#btn_save").removeClass("d-none");
            }
        },
        complete: function () {
            $('.spinner-border').hide();
        }
    });
});

/* Remover Socio */
$(".remove_partner").on("click", function () {
    var name = $(this).data("partnername");

    Swal.fire({
        title: 'Deseja Excluir o Socio <strong><u>' + name + '</u></strong> da empresa selecionada ?',
        html: '<span> Após cancelar esse sócio, ele não constará mais na lista, caso precise, adicione novamente. </span>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "POST",
                url: '<?php printf($GLOBALS["partner_url"], $partner["idx"]) ?>',
                data: {
                    btn_remove: "yes",
                    "no-redirect": "yes"
                },
                beforeSend: function () {
                    $(".spinner-border").show();
                },
                success: function () {
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                },
                complete: function () {
                    $('.spinner-border').hide();
                }
            });
        }
    })
});