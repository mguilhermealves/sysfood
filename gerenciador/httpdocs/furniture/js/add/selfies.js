data_selfies_json.template = '<div class="row_js#CLASS#"#ADD#>';
data_selfies_json.template +=
	'  <div class="cell" style="height: 45px;min-width: 70px !important;overflow:hidden;"#ADD_IMAGE#>#IMAGE#</div>';
data_selfies_json.template +=
	'  <div class="cell" style="height: 45px;min-width: 70px !important;overflow:hidden;"#ADD_NAME#>#NAME#</div>';
data_selfies_json.template +=
	'  <div class="cell" style="height: 45px;min-width: 70px !important;overflow:hidden;"#ADD_CREATED_AT#>#CREATED_AT#</div>';
data_selfies_json.template +=
	'  <div class="cell" style="height: 45px;min-width: 70px !important;overflow:hidden;"#ADD_CREATED_BY#>#CREATED_BY#</div>';
data_selfies_json.template +=
	'  <div class="cell" style="height: 45px;min-width: 70px !important;overflow:hidden;"#ADD_VOTES#>#VOTES#</div>';
data_selfies_json.template +=
	'  <div class="cell cell_last" style="height: 45px;text-align:center !important;min-width: 70px !important;overflow:hidden;"#ADD_ACAO#>#ACAO#</div>';
data_selfies_json.template += "</div>";

data_selfies_json.footer = '<div class="row_js table_data_footer">';
data_selfies_json.footer += ' <div class="cell cell_last table_data_footer">';
data_selfies_json.footer += "     Linha por Página ";
data_selfies_json.footer += '     <select id="per_page">';
data_selfies_json.footer += '         <option value="20" selected>20</option>';
data_selfies_json.footer += '         <option value="50">50</option>';
data_selfies_json.footer += '         <option value="100">100</option>';
data_selfies_json.footer += "     </select>";
data_selfies_json.footer += " </div>";
data_selfies_json.footer +=
	' <div class="cell cell_last table_data_footer" style="justify-content: space-around;" id="paginate_control"></div>';
data_selfies_json.footer +=
	' <div class="cell cell_last table_data_footer" id="paginate_display">#DATA_TOTAL#</div>';
data_selfies_json.footer += "</div>";

$("#export_xls").bind("click", function () {
	var url = $("#frm_filter").prop("action");
	$("#frm_filter").attr({ action: url + ".xls" });
	$("#frm_filter").submit();
	$("#frm_filter").attr({ action: url });
});

$.ajax({
	type: "GET",
	url: data_selfies_json.url,
	data: data_selfies_json.data,
	success: function (data) {
		$.each(data.total, function (i, o) {
			$("#" + i + "SpanUser").html(o);
		});
		data_selfies_json.out_data = data;
		fn_common.render_data(
			data_selfies_json.template + '<div class="row_data"></div>',
			{
				"#CLASS#": " row_js_header",
				"#ADD_IMAGE#": "",
				"#ADD_NAME#": "",
				"#ADD_CREATED_AT#": "",
				"#ADD_CREATED_BY#": "",
				"#ADD_VOTES#": "",
				"#IMAGE#":
					'<button style="width: 100%; background-color: #ffffff; color: #707070; text-align: left; font-weight: bold; padding: 0px;" id="btn_ordenation_image" type="button">Imagem<i class="fa fa-border-none"></i></button>',
				"#NAME#":
					'<button style="width: 100%; background-color: #ffffff; color: #707070; text-align: left; font-weight: bold; padding: 0px;" id="btn_ordenation_name" type="button">Nome do Pet<i class="fa fa-border-none"></i></button>',
				"#CREATED_AT#":
					'<button style="width: 100%; background-color: #ffffff; color: #707070; text-align: left; font-weight: bold; padding: 0px;" id="btn_ordenation_createdat" type="button">Data da Publicação<i class="fa fa-border-none"></i></button>',
				"#CREATED_BY#":
					'<button style="width: 100%; background-color: #ffffff; color: #707070; text-align: left; font-weight: bold; padding: 0px;" id="btn_ordenation_createdby" type="button">Tutor<i class="fa fa-border-none"></i></button>',
				"#VOTES#":
					'<button style="width: 100%; background-color: #ffffff; color: #707070; text-align: left; font-weight: bold; padding: 0px;" id="btn_ordenation_votes" type="button">Qtd de Votos<i class="fa fa-border-none"></i></button>',
				"#ACAO#": "AÇÃO",
				"#ADD_ACAO#": "",
			},
			"#solaris-head-data"
		);
		$.each(data.row, function (i, o) {
			fn_common.render_data(
				data_selfies_json.template,
				{
					"#CLASS#": " table_data_data",
					"#IMAGE#": o.image,
					"#NAME#": o.nome,
					"#ADD_CREATED_AT#": o.created_at,
					"#ADD_CREATED_BY#":
						o.users_attach[0] != undefined
							? o.users_attach[0]["first_name"]
							: "-",
					"#ADD_VOTES#": "",
					"#ADD#":
						' data-image="#ADD_IMAGE#" data-name="#ADD_NAME#" data-createdat="#ADD_CREATED_AT#" data-createdby="#ADD_CREATED_BY#" data-votes="#ADD_VOTES#"',
					"#IMAGE#": "<img src='" + o.image + "' class='img-fluid'>",
					"#CREATED_AT#": String(o.created_at).replace(
						/(^....).(..).(..).(.....).+?/im,
						"$3/$2/$1 $4"
					),
					"#CREATED_BY#":
						o.users_attach[0] != undefined
							? o.users_attach[0]["first_name"]
							: "-",
					"#VOTES#":
						o.votes_attach[0] != undefined
							? Object.keys(o.votes_attach).length
							: 0,
					"#ACAO#":
						'<a href="/selfie/' +
						o.idx +
						'" class="btn button info round"><i class="fontello-edit"></i> Editar</a>',
				},
				"#solaris-head-data .row_data"
			);
		});
		$.each(
			["image", "createdat", "createdby", "name", "votes"],
			function (i, o) {
				$("#btn_ordenation_" + o).bind("click", function () {
					fn_common.ordenation(o);
				});
			}
		);
		fn_common.render_data(
			data_selfies_json.footer,
			{
				"#DATA_TOTAL#": "",
			},
			"#solaris-head-data"
		);
		fn_common.paginate(1);
		$("#per_page").bind("change", function () {
			fn_common.paginate(1);
		});
	},
});

var fn_common = {
	render_data: function (template, data, destine) {
		$.each(data, function (r, p) {
			var t = new RegExp(r, "g");
			template = String(template).replace(t, p);
		});
		$(destine).append(template);
	},
	paginate: function (sr) {
		paginate_control_button =
			'<button type="button" id="btn_#ID#" class="btn">#CONTEXT#</button>';
		per_page = $("option:selected", "#per_page").val();
		paginate = sr * per_page;
		$("#paginate_control").html("");
		$.each(
			{
				first: '<i class="fa fa-angle-double-left"></i>',
				previous: '<i class="fa fa-angle-left"></i>',
				next: '<i class="fa fa-angle-right"></i>',
				last: '<i class="fa fa-angle-double-right"></i>',
			},
			function (i, o) {
				fn_common.render_data(
					paginate_control_button,
					{
						"#CONTEXT#": o,
						"#ID#": i,
					},
					"#paginate_control"
				);
			}
		);

		if (sr == 1) {
			$("#btn_first").prop("disabled", true).unbind("click");
			$("#btn_previous").prop("disabled", true).unbind("click");
		} else {
			$("#btn_first")
				.prop("disabled", false)
				.unbind("click")
				.bind("click", function () {
					fn_common.paginate(1);
				});
			$("#btn_previous")
				.prop("disabled", false)
				.unbind("click")
				.bind("click", function () {
					fn_common.paginate(sr - 1);
				});
		}

		paginate_text = paginate - per_page + 1;

		if (paginate < data_selfies_json.out_data.total.total) {
			last_paginate =
				data_selfies_json.out_data.total.total % per_page == 0
					? data_selfies_json.out_data.total.total / per_page
					: Math.floor(data_selfies_json.out_data.total.total / per_page) + 1;
			paginate_text += " - " + paginate;
			$("#btn_next")
				.prop("disabled", false)
				.unbind("click")
				.bind("click", function () {
					fn_common.paginate(sr + 1);
				});
			$("#btn_last")
				.prop("disabled", false)
				.unbind("click")
				.bind("click", function () {
					fn_common.paginate(last_paginate);
				});
		} else {
			$("#btn_next").prop("disabled", true).unbind("click");
			$("#btn_last").prop("disabled", true).unbind("click");
		}
		paginate_text += " de " + data_selfies_json.out_data.total.total;

		$(".row_data .table_data_data").hide();
		$(".row_data .table_data_data")
			.slice(paginate - per_page, paginate)
			.css({ display: "flex" });
		$("#paginate_display").html(paginate_text);
	},
	ordenation: function (obj) {
		var ordernation = $("#btn_ordenation_" + obj + " i").hasClass(
			"fa-angle-up"
		);
		$.each($(".row_js_header button i"), function (i, o) {
			$(o)
				.removeClass("fa-border-none")
				.removeClass("fa-angle-up")
				.removeClass("fa-angle-down")
				.addClass("fa-border-none");
		});
		$("#btn_ordenation_" + obj + " i")
			.removeClass("fa-border-none")
			.addClass(ordernation ? "fa-angle-down" : "fa-angle-up");
		$(".row_data .table_data_data")
			.sort(function (a, b) {
				return (
					ordernation
						? $(b).data(obj) > $(a).data(obj)
						: $(b).data(obj) < $(a).data(obj)
				)
					? 1
					: -1;
			})
			.appendTo(".row_data");
	},
};
