<?php
class manuals_controller
{
	public static function data4select($key = "idx", $filters = array(" active = 'yes' "), $field = "name")
	{
		$boiler = new manuals_model();
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
		// if (!in_array($_SESSION[constant("cAppKey")]["credential"]["profiles_attach"][0]["idx"], array(1, 2)) && !in_array($_SESSION[constant("cAppKey")]["credential"]["profiles_attach"][0]["slug"], array('adm-premier', 'gestor-hsol'))) {
		// 	//$done["filter_profiles"] = $info["get"]["filter_profiles"];
		// 	$profiles_id = array_keys(profiles_controller::data4select("idx", array($_SESSION[constant("cAppKey")]["credential"]["profiles_attach"][0]["idx"] . " in ( idx, parent ) ")));
		// 	$filter["filter_profiles"] = " idx in ( select trails_profiles.trails_id from trails_profiles where trails_profiles.active = 'yes' and trails_profiles.profiles_id in ( '" . implode("','", $profiles_id) . "') ) ";
		// } else {
		// 	if (isset($info["get"]["filter_profiles"]) && !empty($info["get"]["filter_profiles"])) {
		// 		$done["filter_profiles"] = $info["get"]["filter_profiles"];
		// 		$filter["filter_profiles"] = " idx in ( select trails_profiles.trails_id from trails_profiles where trails_profiles.active = 'yes' and trails_profiles.profiles_id = '" . $info["get"]["filter_profiles"] . "' ) ";
		// 	}
		// }

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
		if (isset($info["get"]["filter_trail_status"]) && !empty($info["get"]["filter_trail_status"])) {
			$done["filter_trail_status"] = $info["get"]["filter_trail_status"];
			$filter["filter_trail_status"] = " trail_status = '" . $info["get"]["filter_trail_status"] . "' ";
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

		$manuals = new manuals_model();

		if ($info["format"] != ".json") {
			$manuals->set_paginate(array($info["sr"], $paginate));
		} else {
			$manuals->set_paginate(array(0, 900000));
		}

		$manuals->set_filter($filter);
		$manuals->set_order(array($ordenation));
		list($total, $data) = $manuals->return_data();

		switch ($info["format"]) {
			case ".json":
				header('Content-type: application/json');
				echo json_encode(
					array(
						"total" => array("total" => $total), "row" => $data
					)
				);
				break;
			default:
				$page = 'Manuais';

				$sidebar_color = "rgba(127, 255, 212, 1)";
				$form = array(
					"done" => rawurlencode(!empty($done) ? set_url($GLOBALS["manuals_url"], $done) : $GLOBALS["manuals_url"]), "pattern" => array(
						"new" => $GLOBALS["newmanual_url"],
						"action" => $GLOBALS["manual_url"],
						"search" => !empty($info["get"]) ? set_url($GLOBALS["manuals_url"], $info["get"]) : $GLOBALS["manuals_url"]
					)
				);

				$ordenation_name = 'display_position-asc';
				$ordenation_name_ordenation = 'bi bi-arrow-up';
				$ordenation_trail = 'trail_title-asc';
				$ordenation_trail_ordenation = 'fas fa-border-none';
				$ordenation_modifiedat = 'modified_at-asc';
				$ordenation_modifiedat_ordenation = 'fas fa-border-none';
				$ordenation_trail_status = 'trail_status-asc';
				$ordenation_trail_status_ordenation = 'fas fa-border-none';
				switch ($ordenation) {
					case 'display_position asc':
						$ordenation_name = 'display_position-desc';
						$ordenation_name_ordenation = 'fas fa-angle-up';
						break;
					case 'display_position desc':
						$ordenation_name = 'display_position-asc';
						$ordenation_name_ordenation = 'bi bi-arrow-down';
						break;
					case 'trail_title asc':
						$ordenation_trail = 'trail_title-desc';
						$ordenation_trail_ordenation = 'fas fa-angle-up';
						break;
					case 'trail_title desc':
						$ordenation_trail = 'trail_title-asc';
						$ordenation_trail_ordenation = 'fas fa-angle-down';
						break;
					case 'modified_at asc':
						$ordenation_modifiedat = 'modified_at-desc';
						$ordenation_modifiedat_ordenation = 'fas fa-angle-up';
						break;
					case 'modified_at desc':
						$ordenation_modifiedat = 'modified_at-asc';
						$ordenation_modifiedat_ordenation = 'fas fa-angle-down';
						break;
					case 'trail_status asc':
						$ordenation_trail_status = 'trail_status-desc';
						$ordenation_trail_status_ordenation = 'fas fa-angle-up';
						break;
					case 'trail_status desc':
						$ordenation_trail_status = 'trail_status-asc';
						$ordenation_trail_status_ordenation = 'fas fa-angle-down';
						break;
				}

				include(constant("cRootServer") . "ui/common/header.inc.php");
				include(constant("cRootServer") . "ui/common/head.inc.php");
				include(constant("cRootServer") . "ui/page/manuals/manuals.php");
				include(constant("cRootServer") . "ui/common/footer.inc.php");
				include(constant("cRootServer") . "ui/common/list_actions.php");
				print('<script>' . "\n");
				print('    data_agendas_json = {' . "\n");
				print('        url: "' . $GLOBALS["scheduleds_url"] . '.json"' . "\n");
				print('        , data: ' . json_encode($done) . "\n");
				print('        , action: "' . set_url($GLOBALS["manual_url"], array("done" => rawurlencode($form["done"]))) . '"' . "\n");
				print('        , template: ""' . "\n");
				print('        , page: 1' . "\n");
				print('    }' . "\n");
				include(constant("cRootServer") . "furniture/js/manuals/manuals.js");
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
			$manual = new manuals_model();
			$manual->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$manual->load_data();
			$manual->attach(array("qrcodes"));
			$data = current($manual->data);

			$form = array(
				"title" => "Editar Manual",
				"url" => sprintf($GLOBALS["manual_url"], $info["idx"])
			);
		} else {
			$data = array();
			$form = array(
				"title" => "Cadastrar Manual",
				"url" => $GLOBALS["newmanual_url"]
			);
		}

		$pages = 'Manuais';
		$page = 'Manual';

		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/manuals/manual.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		print("<script>");
		print('$("button[name=\'btn_back\']").bind("click", function(){');
		print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["trails_url"]) . '" ');
		print('})' . "\n");
		include(constant("cRootServer") . "furniture/js/manuals/manual.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function save($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		$manual = new manuals_model();

		if (isset($info["idx"]) && (int)$info["idx"] > 0) {
			$manual->set_filter(array(" idx = '" . $info["idx"] . "' "));

			$info["post"]["modified_at"] = date("Y-m-d H:i:s");
		}

		if (isset($_FILES["manual_pdf"]) && $_FILES["manual_pdf"]["name"] != "") {

			$d = preg_split("/\./", $_FILES["manual_pdf"]["name"]);

			$extension = $d[count($d) - 1];

			$extension_permited = ["pdf"];

			if (array_search($extension, $extension_permited) >= 0) {
				$name = generate_slug(preg_replace("/\." . $extension . "$/", "", $_FILES["manual_pdf"]["name"]));

				$fullName = date("YmdHis") . "_" . $name . "." . $extension;

				$file = "furniture/upload/manual/" . $fullName;

				if (!file_exists(dirname(constant("cRootServer") . $file))) {
					mkdir(dirname(constant("cRootServer") . $file), 0777, true);
					chmod(dirname(constant("cRootServer") . $file), 0775);
				}

				if (file_exists(constant("cRootServer") . $file)) {
					unlink(constant("cRootServer") . $file);
				}

				move_uploaded_file($_FILES["manual_pdf"]["tmp_name"], constant("cRootServer") . $file);
			} else {
				$_SESSION["messages_app"]["warning"][] = "Não foi possível importar o arquivo [Manual], extensão nao permitida, tipo de arquivos aceitos (.pdf), faça o upload do arquivo novamente.";
			}

			$info["post"]["manual_pdf"] = serialize($file);
		}

		if (isset($_FILES["manual_img"]) && $_FILES["manual_img"]["name"] != "") {

			$d = preg_split("/\./", $_FILES["manual_img"]["name"]);

			$extension = $d[count($d) - 1];

			$name = generate_slug(preg_replace("/\." . $extension . "$/", "", $_FILES["manual_img"]["name"]));

			$fullName = date("YmdHis") . "_" . $name . "." . $extension;

			$file = "furniture/upload/manual/img/" . $fullName;

			if (!file_exists(dirname(constant("cRootServer") . $file))) {
				mkdir(dirname(constant("cRootServer") . $file), 0777, true);
				chmod(dirname(constant("cRootServer") . $file), 0775);
			}

			if (file_exists(constant("cRootServer") . $file)) {
				unlink(constant("cRootServer") . $file);
			}

			move_uploaded_file($_FILES["manual_img"]["tmp_name"], constant("cRootServer") . $file);
			$info["post"]["manual_img"] = $file;
		}

		$manual->populate($info["post"]);
		$manual->save();

		if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
			$info["idx"] = $manual->con->insert_id;
		}

		$_SESSION["messages_app"]["success"] = array("Manual Cadastrado com sucesso.");

		if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
			basic_redir($info["post"]["done"]);
		} else {
			basic_redir($GLOBALS["manuals_url"]);
		}
	}

	public function remove($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		if (isset($info["idx"])) {
			$manual = new manuals_model();

			$manual->set_filter(array(" idx = '" . $info["idx"] . "' "));

			$manual->remove();
		}

		basic_redir($GLOBALS["manuals_url"]);
	}
}
