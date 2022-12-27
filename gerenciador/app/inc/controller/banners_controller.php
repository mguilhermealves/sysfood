<?php
class banners_controller
{
	public static function data4select($key = "idx", $filters = array(" active = 'yes' "), $field = "name")
	{
		$banners = new banners_model();
		$banners->set_field(array($key, $field));
		$banners->set_filter($filters);
		$banners->load_data();
		$out = array();
		foreach ($banners->data as $value) {
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

		$banners = new banners_model();

		if ($info["format"] != ".json") {
			$banners->set_paginate(array($info["sr"], $paginate));
		} else {
			$banners->set_paginate(array(0, 900000));
		}

		$banners->set_filter($filter);
		$banners->load_data();

		$data = $banners->data;
		$total = $banners->con->result($banners->con->select(" ifnull( count( idx ) , 0 ) as s ", " banners ", " where " . implode(" and ", $filter)), "s", 0);
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
				$page = 'Banners';
				$form = array(
					"done" => rawurlencode(!empty($done) ? set_url($GLOBALS["banners_url"], $done) : $GLOBALS["banners_url"]),
					"pattern" => array(
						"distributor" => $GLOBALS["newbanner_url"],
						"action" => $GLOBALS["banner_url"],
						"search" => !empty($info["get"]) ? set_url($GLOBALS["banners_url"], $info["get"]) : $GLOBALS["banners_url"]
					)
				);
				include(constant("cRootServer") . "ui/common/header.inc.php");
				include(constant("cRootServer") . "ui/common/head.inc.php");
				include(constant("cRootServer") . "ui/page/banners/banners.php");
				include(constant("cRootServer") . "ui/common/footer.inc.php");
				print('<script>' . "\n");
				print('    data_banners_json = {' . "\n");
				print('        url: "' . $GLOBALS["banners_url"] . '.json"' . "\n");
				print('        , data: ' . json_encode($done) . "\n");
				print('        , template: ""' . "\n");
				print('        , page: 1' . "\n");
				print('    }' . "\n");
				include(constant("cRootServer") . "furniture/js/add/banners.js");
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

		$profiles_lists = profiles_controller::data4select("idx", array(" editabled != 'no' "), "name");

		if (isset($info["idx"])) {
			$banner = new banners_model();
			$banner->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$banner->load_data();
			$data = current($banner->data);

			$form = array(
				"url" => sprintf($GLOBALS["banner_url"], $info["idx"])
			);
		} else {
			$data = array();
			$form = array(
				"url" => $GLOBALS["newbanner_url"]
			);
		}

		$page = 'Banner';
		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/banners/banner.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		print("<script>");
		print('$("button[name=\'btn_back\']").bind("click", function(){');
		print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["banners_url"]) . '" ');
		print('})' . "\n");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function save($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}
		$banner = new banners_model();

		if (isset($info["idx"]) && (int)$info["idx"] > 0) {
			$banner->set_filter(array(" idx = '" . $info["idx"] . "' "));
		}

		if (isset($_FILES["img"]) && is_file($_FILES["img"]["tmp_name"])) {
			$d = preg_split("/\./", $_FILES["img"]["name"]);
			$extension = $d[count($d) - 1];
			$name = generate_slug(preg_replace("/\." . $extension . "$/", "", $_FILES["img"]["name"]));
			$extension = date("YmdHis") . "." . $extension;
			$file = "furniture/upload/images/banners/" . $name . $extension;

			if (!file_exists(dirname(constant("cRootServer") . $file))) {
				mkdir(dirname(constant("cRootServer") . $file), 0777, true);
				chmod(dirname(constant("cRootServer") . $file), 0775);
			}
			if (file_exists(constant("cRootServer") . $file)) {
				unlink(constant("cRootServer") . $file);
			}

			move_uploaded_file($_FILES["img"]["tmp_name"], constant("cRootServer") . $file);
			$info["post"]["img"] = $file;
		}

		$banner->populate($info["post"]);
		$banner->save();

		if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
			$info["idx"] = $banner->con->insert_id;
		}

		$banner->save_attach($info, array("profiles"));

		if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
			basic_redir($info["post"]["done"]);
		} else {
			basic_redir($GLOBALS["banners_url"]);
		}
	}

	public function remove($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		if (isset($info["idx"])) {
			$banner = new banners_model();
			$banner->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$banner->remove();
		}

		if (isset($info["post"]["no-redirect"])) {
			print("ok");
		} else {
			if (isset($info["post"]["done"])) {
				basic_redir($info["post"]["done"]);
			} else {
				basic_redir($GLOBALS["banners_url"]);
			}
		}
	}
}
