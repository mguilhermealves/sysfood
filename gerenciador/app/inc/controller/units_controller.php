<?php
class units_controller
{
	public static function data4select($key = "idx", $filters = array(" active = 'yes' "), $field = "name")
	{
		$units = new units_model();
		$units->set_field(array($key, $field));
		$units->set_filter($filters);
		$units->load_data();
		$out = array();
		foreach ($units->data as $value) {
			$out[$value[$key]] = $value[preg_replace("/^.+ as (.+)$/", "$1", $field)];
		}
		return $out;
	}

	private function filter($info)
	{
		$done = array();
		$filter = array(" active = 'yes' ");
		if (isset($info["get"]["filter_name"]) && !empty($info["get"]["filter_name"])) {
			$done["filter_name"] = $info["get"]["filter_name"];
			$filter["filter_name"] = " name like '%" . $info["get"]["filter_name"] . "%' ";
		}
		
		if (isset($info["get"]["filter_mtrix"]) && !empty($info["get"]["filter_mtrix"])) {
			$done["filter_mtrix"] = $info["get"]["filter_mtrix"];
			$filter["filter_mtrix"] = " cod_mtrix like '%" . $info["get"]["filter_mtrix"] . "%' ";
		}
		return array($done, $filter);
	}

	public function display($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		$paginate = 10;

		list($done, $filter) = $this->filter($info);

		$units = new units_model();

		if ($info["format"] != ".json") {
			$units->set_paginate(array($info["sr"], $paginate));
		} else {
			$units->set_paginate(array(0, 900000));
		}

		$units->set_filter($filter);
		$units->load_data();

		$data = $units->data;
		$total = $units->con->result($units->con->select(" ifnull( count( idx ) , 0 ) as s ", " units ", " where " . implode(" and ", $filter)), "s", 0);
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
				$page = 'Unidades';
				$form = array(
					"done" => rawurlencode(!empty($done) ? set_url($GLOBALS["units_url"], $done) : $GLOBALS["units_url"]),
					"pattern" => array(
						"distributor" => $GLOBALS["newunit_url"],
						"action" => $GLOBALS["unit_url"],
						"search" => !empty($info["get"]) ? set_url($GLOBALS["units_url"], $info["get"]) : $GLOBALS["units_url"]
					)
				);
				include(constant("cRootServer") . "ui/common/header.inc.php");
				include(constant("cRootServer") . "ui/common/head.inc.php");
				include(constant("cRootServer") . "ui/page/units/units.php");
				include(constant("cRootServer") . "ui/common/footer.inc.php");
				print('<script>' . "\n");
				print('    data_units_json = {' . "\n");
				print('        url: "' . $GLOBALS["units_url"] . '.json"' . "\n");
				print('        , data: ' . json_encode($done) . "\n");
				print('        , template: ""' . "\n");
				print('        , page: 1' . "\n");
				print('    }' . "\n");
				include(constant("cRootServer") . "furniture/js/add/units/units.js");
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
			$unit = new units_model();
			$unit->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$unit->load_data();
			$data = current($unit->data);

			$form = array(
				"url" => sprintf($GLOBALS["unit_url"], $info["idx"])
			);
		} else {
			$data = array();
			$form = array(
				"url" => $GLOBALS["newunit_url"]
			);
		}

		$page = 'Unidades';
		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/units/unit.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		print("<script>");
		print('$("button[name=\'btn_back\']").bind("click", function(){');
		print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["units_url"]) . '" ');
		print('})' . "\n");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function save($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}
		$unit = new units_model();

		if (isset($info["idx"]) && (int)$info["idx"] > 0) {
			$unit->set_filter(array(" idx = '" . $info["idx"] . "' "));
		}

		$unit->populate($info["post"]);
		$unit->save();

		if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
			$info["idx"] = $unit->con->insert_id;
		}

		if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
			basic_redir($info["post"]["done"]);
		} else {
			basic_redir($GLOBALS["units_url"]);
		}
	}

	public function remove($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		if (isset($info["idx"])) {
			$unit = new units_model();
			$unit->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$unit->remove();
		}

		if (isset($info["post"]["no-redirect"])) {
			print("ok");
		} else {
			if (isset($info["post"]["done"])) {
				basic_redir($info["post"]["done"]);
			} else {
				basic_redir($GLOBALS["units_url"]);
			}
		}
	}
}
