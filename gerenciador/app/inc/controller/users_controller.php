<?php
class users_controller
{
	public static function data4select($key = "idx", $filters = array(" active = 'yes' "), $field = "concat_ws(' ', first_name, last_name) as name")
	{
		$return_field = preg_replace("/^.+ as (.+)$/", "$1", $field);
		$users = new users_model();
		$users->set_field(array($key, $field));
		$users->set_filter($filters);
		$users->load_data();
		$out = array_column($users->data, $return_field, $key);
		return $out;
	}

	private function filter($info)
	{
		$done = array();

		$filter = $this->getFilter();

		if (isset($info["get"]["filter_first_name"]) && !empty($info["get"]["filter_first_name"])) {
			$done["filter_first_name"] = $info["get"]["filter_first_name"];
			$filter["filter_first_name"] = " first_name like '" . $info["get"]["filter_first_name"] . "%' ";
		}
		if (isset($info["get"]["filter_last_name"]) && !empty($info["get"]["filter_last_name"])) {
			$done["filter_last_name"] = $info["get"]["filter_last_name"];
			$filter["filter_last_name"] = " last_name like '" . $info["get"]["filter_last_name"] . "%' ";
		}
		if (isset($info["get"]["filter_mail"]) && !empty($info["get"]["filter_mail"])) {
			$done["filter_mail"] = $info["get"]["filter_mail"];
			$filter["filter_mail"] = " mail like '%" . $info["get"]["filter_mail"] . "%' ";
		}
		if (isset($info["get"]["filter_cpf"]) && !empty($info["get"]["filter_cpf"])) {
			$done["filter_cpf"] = $info["get"]["filter_cpf"];
			$filter["filter_cpf"] = " cpf like '" . $info["get"]["filter_cpf"] . "%' ";
		}
		if (isset($info["get"]["filter_phone"]) && !empty($info["get"]["filter_phone"])) {
			$done["filter_phone"] = $info["get"]["filter_phone"];
			$filter["filter_phone"] = " phone like '%" . $info["get"]["filter_phone"] . "%' ";
		}
		if (isset($info["get"]["filter_celphone"]) && !empty($info["get"]["filter_celphone"])) {
			$done["filter_celphone"] = $info["get"]["filter_celphone"];
			$filter["filter_celphone"] = " celphone like '%" . $info["get"]["filter_celphone"] . "%' ";
		}
		if (isset($info["get"]["filter_position"]) && !empty($info["get"]["filter_position"])) {
			$done["filter_position"] = $info["get"]["filter_position"];
			$filter["filter_position"] = " position like '%" . $info["get"]["filter_position"] . "%' ";
		}
		if (isset($info["get"]["filter_regional"]) && !empty($info["get"]["filter_regional"])) {
			$done["filter_regional"] = $info["get"]["filter_regional"];
			$filter["filter_regional"] = " regional like '%" . $info["get"]["filter_regional"] . "%' ";
		}
		if (isset($info["get"]["filter_distribuidora"]) && !empty($info["get"]["filter_distribuidora"])) {
			$done["filter_distribuidora"] = $info["get"]["filter_distribuidora"];
			$filter["filter_distribuidora"] = " distribuidora like '%" . $info["get"]["filter_distribuidora"] . "%' ";
		}
		if (isset($info["get"]["filter_city"]) && !empty($info["get"]["filter_city"])) {
			$done["filter_city"] = $info["get"]["filter_city"];
			$filter["filter_city"] = " city like '%" . $info["get"]["filter_city"] . "%' ";
		}
		if (isset($info["get"]["filter_uf"]) && !empty($info["get"]["filter_uf"])) {
			$done["filter_uf"] = $info["get"]["filter_uf"];
			$filter["filter_uf"] = " uf like '%" . $info["get"]["filter_uf"] . "%' ";
		}
		if (isset($info["get"]["filter_profile"]) && !empty($info["get"]["filter_profile"])) {
			$done["filter_profile"] = $info["get"]["filter_profile"];
			$filter["filter_profile"] = " idx in ( select users_profiles.users_id from users_profiles where users_profiles.active = 'yes' and users_profiles.profiles_id = '" . $info["get"]["filter_profile"] . "' ) ";
		}
		if (isset($info["get"]["filter_mtrix"]) && !empty($info["get"]["filter_mtrix"])) {
			$done["filter_mtrix"] = $info["get"]["filter_mtrix"];
			$filter["filter_mtrix"] = " cod_mtrix like '%" . $info["get"]["filter_mtrix"] . "%' ";
		}

		if (isset($info["get"]["filter_rules"]) && !empty($info["get"]["filter_rules"])) {
			$done["filter_rules"] = $info["get"]["filter_rules"];
			$filter["filter_rules"] = "";
			if ($info["get"]["filter_rules"] == 'yes') {
				$filter["filter_rules"] = " accept_at is not null ";
			} else {
				$filter["filter_rules"] = " accept_at is null ";
			}
		}

		return array($done, $filter);
	}

	public function display($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		list($done, $filter) = $this->filter($info);
		$users = new users_model();

		$paginate = isset($info["get"]["paginate"]) && (int)$info["get"]["paginate"] > 20 ? $info["get"]["paginate"] : 20;

		if (!in_array($info["format"], array(".json", ".xls"))) {
			$users->set_paginate(array($info["sr"], $paginate));
		} else {
			$users->set_paginate(array(0, 900000));
		}

		$users->set_filter($filter);

		$users->load_data();
		$users->attach(array("profiles"), false, null, array("idx", "name"));

		$data = $users->data;
		$total = $users->con->result($users->con->select(" ifnull( count( idx ) , 0 ) as s ", " users ", " where " . implode(" and ", $filter)), "s", 0);

		$profilesLists = profiles_controller::data4select("idx", array(" idx > " . $_SESSION[constant("cAppKey")]["credential"]["profiles_attach"][0]["idx"] . " and adm = 'yes' order by hierarchy "), "name");
		$unitsList = units_controller::data4select("idx", array("active = 'yes'"), "trade_name");

		switch ($info["format"]) {
			case ".xls":
				$name = "Relatorio_de_Usuarios" .  date("d-m-Y-H:s");
				require_once(constant("cRootServer_APP") . '/inc/lib/PHPExcel-1.8/Classes/PHPExcel.php');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("HSOL")
					->setLastModifiedBy("HSOL")
					->setTitle("Relatorio_de_Usuarios")
					->setSubject("Relatorio_de_Usuarios")
					->setDescription("Relatorio_de_Usuarios")
					->setKeywords("Relatorio_de_Usuarios")
					->setCategory("Relatorio_de_Usuarios");

				$objPHPExcel->setActiveSheetIndex(0)->setTitle('Relatorio_de_Usuarios');
				$x_in = 1;

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x_in, 'Nome');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $x_in, 'E-mail');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x_in, 'CPF');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $x_in, 'Perfil');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $x_in, 'Cargo');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $x_in, 'Regional');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $x_in, 'Distribuidora');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $x_in, 'Ativo');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $x_in, 'Data do Aceite');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $x_in, 'Data do Ultimo Login');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $x_in, 'Celular');
				foreach ($data as $k => $v) {
					$x_in++;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x_in, $v["first_name"] . ' ' . $v["last_name"]);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $x_in, !empty($v["mail"]) ? $v["mail"] : "-");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x_in, !empty($v["cpf"]) ? $v["cpf"] : "-");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $x_in, !empty($v["profiles_attach"][0]) ? $v["profiles_attach"][0]["name"] : "-");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $x_in, !empty($v["position"]) ? $v["position"] : "-");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $x_in, !empty($v["regional"]) ? $v["regional"] : "-");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $x_in, !empty($v["distributors_attach"][0]) ? $v["distributors_attach"][0]["name"] : "-");

					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $x_in, $v["enabled"] == "yes" ? "Sim" : "Não");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $x_in, !empty($v["accept_at"]) ? preg_replace("/^(....).(..).(..).(.....).+/", "$3/$2/$1 $4", $v["accept_at"]) : "");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $x_in, !empty($v["last_login"]) ? preg_replace("/^(....).(..).(..).(.....).+/", "$3/$2/$1 $4", $v["last_login"]) : "Não Logou");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $x_in, !empty($v["celphone"]) ? $v["celphone"] : "-");
				}
				$objPHPExcel->setActiveSheetIndex(0);
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="' . $name . '.xlsx"');

				header('Cache-Control: max-age=0');
				header('Cache-Control: max-age=1');
				header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
				header('Cache-Control: cache, must-revalidate');
				header('Pragma: public');
				$objWriter->setIncludeCharts(TRUE);
				$objWriter->save('php://output');
				$objWriter->setOffice2003Compatibility(true);
				$objPHPExcel->disconnectWorksheets();
				$objPHPExcel->garbageCollect();
				unset($objPHPExcel);
				exit();
				break;
			case ".json":
				$t = array_count_values(array_column($users->con->results($users->con->select(" idx , if( last_login is null , 'yes' , 'no' ) as enabled ", " users ", " where " . implode(" and ", $filter))), "enabled", "idx"));
				foreach (array_keys($GLOBALS["yes_no_lists"]) as $k) {
					if (!isset($t[$k])) {
						$t[$k] = 0;
					}
				}
				header('Content-type: application/json');
				echo json_encode(
					array(
						"total" => array_merge(array("total" => array_sum($t)), $t), "row" => $data, "profiles" => $profilesLists
					)
				);
				break;
			default:
				$page = 'Usuarios';
				$form = array(
					"done" => rawurlencode(!empty($done) ? set_url($GLOBALS["users_url"], $done) : $GLOBALS["users_url"]), "pattern" => array(
						"new" => $GLOBALS["newuser_url"], "action" => $GLOBALS["user_url"], "search" => !empty($info["get"]) ? set_url($GLOBALS["users_url"], $info["get"]) : $GLOBALS["users_url"]
					)
				);
				include(constant("cRootServer") . "ui/common/header.inc.php");
				include(constant("cRootServer") . "ui/common/head.inc.php");
				include(constant("cRootServer") . "ui/page/users.php");
				include(constant("cRootServer") . "ui/common/footer.inc.php");
				include(constant("cRootServer") . "ui/common/list_actions.php");
				print('<script>' . "\n");
				print('    data_users_json = {' . "\n");
				print('        url: "' . $GLOBALS["users_url"] . '.json"' . "\n");
				print('        , data: ' . json_encode($done) . "\n");
				print('        , template: ""' . "\n");
				print('        , page: 1' . "\n");
				print('    }' . "\n");
				include(constant("cRootServer") . "furniture/js/add/users.js");
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

		$unitsList = units_controller::data4select("idx", array("active = 'yes'"), "trade_name");
		$profilesLists = profiles_controller::data4select("idx", array(" idx >= " . $_SESSION[constant("cAppKey")]["credential"]["profiles_attach"][0]["idx"] . " and adm = 'yes' order by hierarchy "), "name");

		$parentList = $this->getParent();

		if (isset($info["idx"])) {
			$users = new users_model();
			$users->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$users->load_data();
			$users->attach(array("profiles"));
			$data = current($users->data);

			$form = array(
				"url" => sprintf($GLOBALS["user_url"], $info["idx"])
			);
		} else {
			$form = array(
				"url" => $GLOBALS["newuser_url"]
			);
		}

		$page = 'Usuarios';

		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/user.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		print("<script>");
		print('$("button[name=\'btn_back\']").bind("click", function(){');
		print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["users_url"]) . '" ');
		print('})' . "\n");
		include(constant("cRootServer") . "furniture/js/add/user.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function save($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		// if ((int)$info["post"]["tokens_id"] == 0) {
		// 	$tokens = new tokens_model();
		// 	$tokens->populate(array("name" => $info["post"]["tokens_name"]));
		// 	$tokens->save();
		// 	$info["post"]["tokens_id"] = $tokens->con->insert_id;
		// }
		if (isset($info["post"]["cpf"])) {
			$info["post"]["cpf"] = preg_replace("/[^0-9]+?/", "", $info["post"]["cpf"]);
		}

		if (isset($info["post"]["mail"]) && (!isset($info["idx"]) || (int)$info["idx"] == 0)) {
			$info["idx"] = (int)current(users_controller::data4select("idx", array(" mail = '" . $info["post"]["mail"] . "' "), "idx"));
		}
		if (isset($info["post"]["cpf"]) && (!isset($info["idx"]) || (int)$info["idx"] == 0)) {
			$info["idx"] = (int)current(users_controller::data4select("idx", array(" cpf = '" . $info["post"]["cpf"] . "' "), "idx"));
		}

		$users = new users_model();
		if (isset($info["idx"]) && (int)$info["idx"] > 0) {
			$uuid = md5(uniqid($info["idx"], true));

			$users->set_filter(array(" idx = '" . $info["idx"] . "' ", "uuid = '" . $uuid . "'"));
		}

		$users->populate($info["post"]);
		$users->save();
		if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
			$info["idx"] = $users->con->insert_id;

			$uuid = md5(uniqid($info["idx"], true));

			$boiler = new users_model();
			$boiler->populate([
				'uuid' => $uuid
			]);
			$boiler->save();
		}

		$users->save_attach($info, array("profiles"));


		if (isset($info["post"]["no-redirect"])) {
			return true;
		} else {
			if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
				basic_redir($info["post"]["done"]);
			} else {
				basic_redir($GLOBALS["users_url"]);
			}
		}
	}

	public function remove($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}
		if (isset($info["idx"])) {
			$news = new users_model();
			$news->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$news->remove();
		}
		if (isset($info["post"]["no-redirect"])) {
			print("ok");
		} else {
			if (isset($info["post"]["done"])) {
				basic_redir($info["post"]["done"]);
			} else {
				basic_redir($GLOBALS["users_url"]);
			}
		}
	}

	public static function getFilter()
	{
		switch ($_SESSION[constant("cAppKey")]["credential"]["profiles_attach"][0]["slug"]) {
			case 'administrador':
				$filter = array(" active = 'yes' ",  " idx in ( select users_profiles.users_id from users_profiles where users_profiles.active = 'yes' and users_profiles.profiles_id > " . $_SESSION[constant("cAppKey")]["credential"]["profiles_attach"][0]["idx"] . " and active = 'yes' ) ");
				break;
			case 'supervisor':
				$filter = array(" active = 'yes' ",  " idx in ( select users_profiles.users_id from users_profiles where users_profiles.active = 'yes' and users_profiles.profiles_id > " . $_SESSION[constant("cAppKey")]["credential"]["profiles_attach"][0]["idx"] . " and active = 'yes' ) ", "parent = " . $_SESSION[constant("cAppKey")]["credential"]["idx"] . "");
				break;
			case 'gerente':
				$filter = array(" active = 'yes' ",  " idx in ( select users_id FROM users_profiles WHERE active = 'yes' and  profiles_id in ( select idx from profiles where hierarchy >= 3)) and parent = " . $_SESSION[constant("cAppKey")]["credential"]["parent"] . " ");
				break;
			case 'usuario-1':
			case 'usuario-2':
				$filter = array(" active = 'yes' ",  " idx in ( select users_profiles.users_id from users_profiles where users_profiles.active = 'yes' and users_profiles.profiles_id > " . $_SESSION[constant("cAppKey")]["credential"]["profiles_attach"][0]["idx"] . " and active = 'yes' ) ");
				break;
			default:
				$filter = array(" active = 'yes' ");
				break;
		}

		return $filter;
	}

	public static function getParent()
	{
		$boiler = new users_model();
		$boiler->set_filter(array(" idx in ( select users_profiles.users_id from users_profiles where users_profiles.active = 'yes' and users_profiles.profiles_id = 40 )"));
		$boiler->load_data();

		return $boiler->data;
	}
}
