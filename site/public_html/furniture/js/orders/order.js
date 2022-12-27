$(document).ready(function () {

    $('body').keypress(function (event) {
        if (event.keyCode == '13') {
            return false;
        }
    });

    $('.money').mask("#.##0,00", {
        reverse: true
    });

    $('.percent').mask('#.##0,00', {
        reverse: true
    });
});

$(".clients_name_search").autocomplete({
    serviceUrl: '<?php print($GLOBALS["clients_url"]) ?>.autocomplete?autcomplete_field=name',
    autoFocus: true,
    minChars: 3,
    deferRequestBy: 5,
    noCache: true,
    onSelect: function (sugestion) {
        $("#clients_id").val(sugestion.data.idx);
        $(".clients_phone_search").val(sugestion.data.phone);
        $(".clients_name_search").val(sugestion.data.first_name);
        $(".clients_cnpj_search").val(sugestion.data.cpf);
    }
});

$(".clients_cnpj_search").autocomplete({
    serviceUrl: '<?php print($GLOBALS["clients_url"]) ?>.autocomplete?autcomplete_field=cpf',
    autoFocus: true,
    minChars: 3,
    deferRequestBy: 5,
    noCache: true,
    onSelect: function (sugestion) {
        $("#clients_id").val(sugestion.data.idx);
        $(".clients_phone_search").val(sugestion.data.phone);
        $(".clients_name_search").val(sugestion.data.first_name);
        $(".clients_cnpj_search").val(sugestion.data.cpf);
    }
});

$(".clients_phone_search").autocomplete({
    serviceUrl: '<?php print($GLOBALS["clients_url"]) ?>.autocomplete?autcomplete_field=phone',
    autoFocus: true,
    minChars: 3,
    deferRequestBy: 5,
    noCache: true,
    onSelect: function (sugestion) {
        $("#clients_id").val(sugestion.data.idx);
        $(".clients_phone_search").val(sugestion.data.phone);
        $(".clients_name_search").val(sugestion.data.first_name);
        $(".clients_cnpj_search").val(sugestion.data.cpf);
    }
});

$("#cancellation_order").on("click", function () {
    var idx = $(this).data("orderId");

    Swal.fire({
        title: 'Deseja Cancelar esse Pedido?',
        html: '<span> o Gerente receberá um e-mail com o <strong>cancelamento</strong> desse pedido. </span>',
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
                url: '/cancelation_meeting',
                data: {
                    idx: idx
                },
                beforeSend: function () {
                    $(".spinner-border").show();
                },
                success: function () {
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                },
                complete: function () {
                    $('.spinner-border').hide();
                }
            });
        }
    })
});

/* begin services */
$("#search_services").autocomplete({
    serviceUrl: '<?php print( $GLOBALS["typeservices_url"] ) ?>.autocomplete?autcomplete_field=q_name',
    minChars: 3,
    deferRequestBy: 5,
    noCache: true,
    onSelect: function (sugestion) {
        $("#search_services").val(sugestion.data.Ds_FornecedorProduto);
        $("#services_id").val(sugestion.data.idx);
        $("#has_tributed").val(sugestion.data.is_taxed == "yes" ? "Sim" : "Não");
    }
});

$("#service_value").on('change', function () {

    let tax_value = $("#tax_value").val();

    let result = $(this).val().replace(",", ".") * tax_value.replace(",", ".") / 100;

    let IR_value = $("#IR_value").val(parseFloat(result)
        .toFixed(2)
        .replace(".", ",")
        .replace(/(.+)(...),00/, "$1.$2,00"));

    let amount = $("#amount").val($(this).val().replace(",", ".") - result);
});

$("#btn_add_item").on('click', function() {

    var outer = '<tr id="tr_#IDX#">';
    outer += '	<td> ';
    outer += '	<input type="hidden" value="#IDX#" name="idproduto[]" /> ';
    outer += '	<input type="hidden" value="#QTDE#" name="qtdeproduto[]" /> ';
    outer += ' </td>';
    outer += '	<td>#NOME_PRODUTO#</td>';
    outer += '	<td>#VALOR_UNITARIO#</td>';
    outer += '	<td>#VALOR_TOTAL#</td>';
    outer += '  <td><input type="hidden" id="valor_total_#IDX#" value="#VALOR_TOTAL_HIDDEN#" /><button id="btn_remove_#IDX#" data-idprod="#IDX#" class="btn btn-danger btn-sm remove">Excluir</button></td>';
    outer += '</tr>';

    outer = String(outer).replace(/#IDX#/gim, $("#id_produto_hidden").val()).replace(/#IMAGEM#/gim, $("#imagem_produto_hidden").val()).replace(/#PRODUTO#/gim, $("#search_product").val()).replace(/#QTDE#/gim, $("#qtde").val()).replace(/#VALOR_UNITARIO#/gim, parseFloat($("#valor_unitario_hidden").val())
        .toFixed(2)
        .replace(".", ",")
        .replace(/(.+)(...),00/, "$1.$2,00")).replace(/#VALOR_TOTAL#/gim,

        parseFloat($("#valor_total_hidden").val())
        .toFixed(2)
        .replace(".", ",")
        .replace(/(.+)(...),00/, "$1.$2,00")

    ).replace(/#VALOR_TOTAL_HIDDEN#/gim, $("#valor_total_hidden").val());
    $("#tbl_services tbody").append(outer);

    var total_estimado = $("#total_estimado_hidden").val();
    console.log(total_estimado);
    total_estimado = parseFloat(total_estimado) + parseFloat($("#valor_total_hidden").val());

    $("#total_estimado_hidden").val(total_estimado);
    $("#total_estimado").empty();
    $("#total_estimado").prepend(parseFloat($("#total_estimado_hidden").val())
        .toFixed(2)
        .replace(".", ",")
        .replace(/(.+)(...),00/, "$1.$2,00"));

    $(".form-add-prod input").val('');

    $("button[id^='btn_remove_']").unbind("click").bind("click", function() {
        var total_estimado = $("#total_estimado_hidden").val();
        total_estimado = parseFloat(total_estimado) - parseFloat($("#valor_total_" + $(this).data('idprod')).val());
        $("#total_estimado_hidden").val(total_estimado);
        $("#total_estimado").empty();
        $("#total_estimado").prepend(parseFloat($("#total_estimado_hidden").val())
            .toFixed(2)
            .replace(".", ",")
            .replace(/(.+)(...),00/, "$1.$2,00"));
        $("#tr_" + $(this).data('idprod')).remove();
    });

    var rowCount = $('#tbl_produtos').rowCount();
    if (rowCount > 0) {
        $("tr.hidden").removeClass('hidden');
    }
});


$.fn.rowCount = function() {
    return $('tr', $(this).find('tbody')).length;
};
/* end services */