$("#btn_add_goaltype").bind("click", function () {
    productbase.add_table(
        {
            id_key: Math.floor(Math.random() * 1000000)
            , idx_goalstype: $("option:selected", "select[id='name_goaltype']").val()
            , name_goaltype: $("option:selected", "select[id='name_goaltype']").text()
        }
    );
})

productbase = {
    add_table: function (data) {
        if (data.name_goaltype != "") {
            var out = '<tr id="tr_' + data.id_key + '">';
            out += '	<td>';
            if (data.idx != undefined) {
                out += '		<input type="hidden" name="productbase[' + data.id_key + '][idx]" value="' + data.idx + '">';
            }
            out += '		<input type="hidden" name="productbase[' + data.id_key + '][post][goalstypes_id]" value="' + data.idx_goalstype + '">';
            out += '		<input type="hidden" name="productbase[' + data.id_key + '][post][name]" value="' + data.name_goaltype + '">';
            out += '		' + data.name_goaltype + '</td>';
            out += '	<td><a id="btn_del_meta_' + data.id_key + '" class="btn button alert round" href="#"><i class="fontello-trash"></i></a></td>';
            out += '</tr>';

            $("#tbl_goals tbody").append(out);
            $("#btn_del_meta_" + data.id_key).bind("click", function () {
                if (confirm('Deseja remover a Meta?')) {
                    $('#tr_' + data.id_key).remove();
                }
                return false;
            })
        }
        $("#name_goaltype").val('')
    }
}
