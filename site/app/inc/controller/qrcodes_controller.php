<?php
class qrcodes_controller
{
	public static function data4select($key = "idx", $filters = array(" active = 'yes' "), $field = "name")
	{
		$boiler = new qrcodes_model();
		$boiler->set_field(array($key, $field));
		$boiler->set_order(array(" name asc "));
		$boiler->set_filter($filters);
		$boiler->load_data();
		$out = array();
		foreach ($boiler->data as $value) {
			$out[$value[$key]] = $value[$field];
		}
		return $out;
	}

	private function filter($info)
	{
		$done = array();
		$filter = array(" active = 'yes' ");

		if (isset($info["get"]["paginate"]) && !empty($info["get"]["paginate"])) {
			$done["paginate"] = $info["get"]["paginate"];
		}
		if (isset($info["get"]["sr"]) && !empty($info["get"]["sr"])) {
			$done["sr"] = $info["get"]["sr"];
		}
		if (isset($info["get"]["ordenation"]) && !empty($info["get"]["ordenation"])) {
			$done["ordenation"] = $info["get"]["ordenation"];
		}
		if (isset($info["get"]["filter_id"]) && !empty($info["get"]["filter_id"])) {
			$done["filter_id"] = $info["get"]["filter_id"];
			$filter["filter_id"] = " idx like '%" . $info["get"]["filter_id"] . "%' ";
		}

		if (isset($info["get"]["filter_title"]) && !empty($info["get"]["filter_title"])) {
			$done["filter_title"] = $info["get"]["filter_title"];
			$filter["filter_title"] = " trail_title like '%" . $info["get"]["filter_title"] . "%' ";
		}

		if (isset($info["get"]["filter_name"]) && !empty($info["get"]["filter_name"])) {
			$done["filter_name"] = $info["get"]["filter_name"];
			$filter["filter_name"] = " trail_title like '%" . $info["get"]["filter_name"] . "%' ";
		}
		return array($done, $filter);
	}

	public function display($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		$paginate = isset($info["get"]["paginate"]) && (int)$info["get"]["paginate"] > 20 ? $info["get"]["paginate"] : 20;
		$ordenation = isset($info["get"]["ordenation"]) ? preg_replace("/-/", " ", $info["get"]["ordenation"]) : 'idx asc';

		list($done, $filter) = $this->filter($info);

		$qrcodes = new qrcodes_model();

		if ($info["format"] != ".json") {
			$qrcodes->set_paginate(array($info["sr"], $paginate));
		} else {
			$qrcodes->set_paginate(array(0, 900000));
		}

		$qrcodes->set_filter($filter);
		$qrcodes->set_order(array($ordenation));
		list($total, $data) = $qrcodes->return_data();
		$data = $qrcodes->data;

		switch ($info["format"]) {
			case ".json":
				header('Content-type: application/json');
				echo json_encode(
					array(
						"total" => array("total" => $total),
						"row" => $data
					)
				);
				break;
			default:
				$page = 'QRcodes';

				$sidebar_color = "rgba(127, 255, 212, 1)";

				$form = array(
					"done" => rawurlencode(!empty($done) ? set_url($GLOBALS["qrcodes_url"], $done) : $GLOBALS["qrcodes_url"]),
					"pattern" => array(
						"new" => $GLOBALS["newqrcode_url"],
						"action" => $GLOBALS["qrcode_url"],
						"search" => !empty($info["get"]) ? set_url($GLOBALS["qrcodes_url"], $info["get"]) : $GLOBALS["qrcodes_url"]
					)
				);

				$ordenation_idx = 'idx-asc';
				$ordenation_idx_ordenation = 'bi bi-arrow-up';
				$ordenation_name = 'name-asc';
				$ordenation_name_ordenation = 'bi bi-arrow-up';
				switch ($ordenation) {
					case 'idx asc':
						$ordenation_idx = 'idx-desc';
						$ordenation_idx_ordenation = 'bi bi-arrow-up';
						break;
					case 'idx desc':
						$ordenation_idx = 'idx-asc';
						$ordenation_idx_ordenation = 'bi bi-arrow-down';
						break;
					case 'name asc':
						$ordenation_name = 'name-desc';
						$ordenation_name_ordenation = 'bi bi-arrow-up';
						break;
					case 'name desc':
						$ordenation_name = 'name-asc';
						$ordenation_name_ordenation = 'fas fa-angle-down';
						break;
				}

				include(constant("cRootServer") . "ui/common/header.inc.php");
				include(constant("cRootServer") . "ui/common/head.inc.php");
				include(constant("cRootServer") . "ui/page/qrcodes/qrcodes.php");
				include(constant("cRootServer") . "ui/common/footer.inc.php");
				include(constant("cRootServer") . "ui/common/list_actions.php");
				print('<script>' . "\n");
				include(constant("cRootServer") . "furniture/js/qrcodes/qrcodes.js");
				print('</script>' . "\n");
				include(constant("cRootServer") . "ui/common/foot.inc.php");
				break;
		}
	}

	public function form($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		if (isset($info["idx"])) {
			$qrcode = new qrcodes_model();
			$qrcode->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$qrcode->load_data();
			$qrcode->attach(array("manuals"));
			$data = current($qrcode->data);

			$form = array(
				"title" => "Editar QRcode",
				"url" => sprintf($GLOBALS["qrcode_url"], $info["idx"])
			);
		} else {
			$data = array();
			$form = array(
				"title" => "Cadastrar QRcode",
				"url" => $GLOBALS["newqrcode_url"]
			);
		}

		$pages = 'QrCodes';
		$page = 'QrCode';

		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/qrcodes/qrcode.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		print("<script>");
		print('$("button[name=\'btn_back\']").bind("click", function(){');
		print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["qrcodes_url"]) . '" ');
		print('})' . "\n");
		include(constant("cRootServer") . "furniture/js/qrcodes/qrcode.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function save($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		$qrcode = new qrcodes_model();

		if (isset($info["idx"]) && (int)$info["idx"] > 0) {
			$qrcode->set_filter(array(" idx = '" . $info["idx"] . "' "));
		} else {
			$info["post"]["modified_at"] = date("Y-m-d H:i:s");
		}

		if (isset($info["post"]["is_new"]) && $info["post"]["is_new"] == "on") {
			// nao atualizar os qrcodes legados
			if (isset($info["idx"]) && (int)$info["idx"] != in_array((int)$info["idx"], array(1, 2, 3, 4))) {
				/* GERAR QRCODE */
				include(constant("cRootServer_APP") . '/inc/lib/phpqrcode/qrlib.php'); // creates code image and outputs it directly into browser

				$ext = ".png";

				$name = generate_slug("qrcode_" .  "_"  . date("YmdHis"));
				$file = "furniture/upload/qrcode/file/" . $name . $ext;

				if (!file_exists(dirname(constant("cRootServer") . $file))) {
					mkdir(dirname(constant("cRootServer") . $file), 0777, true);
					chmod(dirname(constant("cRootServer") . $file), 0775);
				}
				if (file_exists(constant("cRootServer") . $file)) {
					unlink(constant("cRootServer") . $file);
				}

				$link = "http://www.aartelecom.com/manual/" . $info["post"]["manuals_id"];

				QRcode::png($link, $file);

				//move_uploaded_file($_FILES["thumb"]["tmp_name"], constant("cRootServer") . $file);
				$info["post"]["url"] = $file;
				$info["post"]["link"] = $link;
			}
		}

		$qrcode->populate($info["post"]);
		$qrcode->save();

		if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
			$info["idx"] = $qrcode->con->insert_id;
		}

		$qrcode->save_attach($info, array("manuals"));

		$_SESSION["messages_app"]["success"] = array("QRcode cadastrado com sucesso.");

		if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
			basic_redir($info["post"]["done"]);
		} else {
			basic_redir($GLOBALS["qrcodes_url"]);
		}
	}

	public function remove($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		if (isset($info["idx"])) {
			$company = new qrcodes_model();

			$company->set_filter(array(" idx = '" . $info["idx"] . "' "));

			$company->remove();
		}

		basic_redir($GLOBALS["qrcodes_url"]);
	}
}
