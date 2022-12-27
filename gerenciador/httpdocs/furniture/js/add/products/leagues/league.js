$("#btn_add_equip").bind("click", function () {
    companie.add_table(
        {
            id_key: Math.floor(Math.random() * 1000000)
            , idx_companie: $("option:selected", "select[id='name_companie']").val()
            , name_companie: $("option:selected", "select[id='name_companie']").text()
        }
    );
})

companie = {
    add_table: function (data) {
        if (data.name_companie != "") {
            var out = '<tr id="tr_' + data.id_key + '">';
            out += '	<td>';
            if (data.idx != undefined) {
                out += '		<input type="hidden" name="companie[' + data.id_key + '][idx]" value="' + data.idx + '">';
            }
            out += '		<input type="hidden" name="companie[' + data.id_key + '][post][company_id]" value="' + data.idx_companie + '">';
            out += '		<input type="hidden" name="companie[' + data.id_key + '][post][name]" value="' + data.name_companie + '">';
            out += '		' + data.name_companie + '</td>';
            out += '	<td><a id="btn_del_meta_' + data.id_key + '" class="btn button alert round" href="#"><i class="fontello-trash"></i></a></td>';
            out += '</tr>';

            $("#tbl_group tbody").append(out);
            $("#btn_del_meta_" + data.id_key).bind("click", function () {
                if (confirm('Deseja excluir a Equipe do Grupo?')) {
                    $('#tr_' + data.id_key).remove();
                }
                return false;
            })
        }
        $("#name_companie").val('')
    }
}
