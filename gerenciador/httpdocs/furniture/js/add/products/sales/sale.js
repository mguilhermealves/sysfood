$("#btn_add_goaltype").bind("click", function () {
    kpi_salecruzade.add_table(
        {
            id_key: Math.floor(Math.random() * 1000000),
            name_goaltype: $("option:selected", "select[id='name_goaltype']").text(),
            point: $("#point").val()
        }
    );
})

kpi_salecruzade = {
    add_table: function (data) {
        console.log(data, true);
        if (data.name_goaltype != "") {
            var out = '<tr id="tr_' + data.id_key + '">';
            out += '	<td>';
            if (data.idx != undefined) {
                out += '		<input type="hidden" name="kpi_salecruzade[' + data.id_key + '][idx]" value="' + data.idx + '">';
            }
            out += '		<input type="hidden" name="kpi_salecruzade[' + data.id_key + '][post][name]" value="' + data.name_goaltype + '">';
            out += '		<input type="hidden" name="kpi_salecruzade[' + data.id_key + '][post][point]" value="' + data.point + '">';
            out += '		' + data.name_goaltype + '</td>';
            out += '	<td>' + data.point + '</td>';
            out += '	<td><a id="btn_del_meta_' + data.id_key + '" class="btn button alert round" href="#"><i class="fontello-trash"></i></a></td>';
            out += '</tr>';

            $("#tbl_kpi_salecruzade tbody").append(out);
            $("#btn_del_meta_" + data.id_key).bind("click", function () {
                if (confirm('Deseja remover a Meta?')) {
                    $('#tr_' + data.id_key).remove();
                }
                return false;
            })
        }
        $("#name_goaltype").val('')
        $("#point").val('')
    }
}
