<?php
class distributors_controller
{
	public static function data4select($key = "idx", $filters = array(" active = 'yes' "), $field = "name")
	{
		$distributors = new distributors_model();
		$distributors->set_field(array($key, $field));
		$distributors->set_filter($filters);
		$distributors->load_data();
		$out = array();
		foreach ($distributors->data as $value) {
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

		$distributors = new distributors_model();

		$distributors->set_field(array(" idx ", " name ", " cod_mtrix ", " active "));

		if ($info["format"] != ".json") {
			$distributors->set_paginate(array($info["sr"], $paginate));
		} else {
			$distributors->set_paginate(array(0, 900000));
		}

		$distributors->set_filter($filter);
		$distributors->load_data();
	
		$data = $distributors->data;
		$total = $distributors->con->result($distributors->con->select(" ifnull( count( idx ) , 0 ) as s ", " distributors ", " where " . implode(" and ", $filter)), "s", 0);
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
				$page = 'distributors';
				$form = array(
					"done" => rawurlencode(!empty($done) ? set_url($GLOBALS["distributors_url"], $done) : $GLOBALS["distributors_url"]), "pattern" => array(
						"distributor" => $GLOBALS["newdistributors_url"], "action" => $GLOBALS["distributor_url"], "search" => !empty($info["get"]) ? set_url($GLOBALS["distributors_url"], $info["get"]) : $GLOBALS["distributors_url"]
					)
				);
				include(constant("cRootServer") . "ui/common/header.inc.php");
				include(constant("cRootServer") . "ui/common/head.inc.php");
				include(constant("cRootServer") . "ui/page/distributors.php");
				include(constant("cRootServer") . "ui/common/footer.inc.php");
				print('<script>' . "\n");
				print('    data_distributors_json = {' . "\n");
				print('        url: "' . $GLOBALS["distributors_url"] . '.json"' . "\n");
				print('        , data: ' . json_encode($done) . "\n");
				print('        , template: ""' . "\n");
				print('        , page: 1' . "\n");
				print('    }' . "\n");
				include(constant("cRootServer") . "furniture/js/add/distributors.js");
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
			$distributors = new distributors_model();
			$distributors->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$distributors->load_data();
			//$distributors->attach(array("profiles"));
			$data = current($distributors->data);

			$form = array(
				"url" => sprintf($GLOBALS["distributor_url"], $info["idx"])
			);
		} else {
			$data = array();
			$form = array(
				"url" => $GLOBALS["newdistributors_url"]
			);
		}

		$page = 'distributor';
		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/distributor.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		print("<script>");
		print('$("button[name=\'btn_back\']").bind("click", function(){');
		print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["distributors_url"]) . '" ');
		print('})' . "\n");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function save($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}
		$distributors = new distributors_model();

		if (isset($info["idx"]) && (int)$info["idx"] > 0) {
			$distributors->set_filter(array(" idx = '" . $info["idx"] . "' "));
		}

		$distributors->populate($info["post"]);
		$distributors->save();

		if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
			$info["idx"] = $distributors->con->insert_id;
		}

		// $distributors->save_attach($info, array("profiles"));

		if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
			basic_redir($info["post"]["done"]);
		} else {
			basic_redir($GLOBALS["distributors_url"]);
		}
	}

	public function remove( $info ){    
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }
    if( isset( $info["idx"] ) ){
      $news = new distributors_model();
      $news->set_filter( array( " idx = '" . $info["idx"] . "' " ) ) ;
      $news->remove();			
    }	
    if( isset( $info["post"]["no-redirect"] ) ){
      print("ok");
    }
    else{
      if( isset( $info["post"]["done"] ) ){
        basic_redir( $info["post"]["done"] ) ;
      }
      else{
        basic_redir( $GLOBALS["distributors_url"] ) ;
      }
    }
  }
}
