<?php
class selfies_pets_controller
{
	public static function data4select($key = "idx", $filters = array(" active = 'yes' "), $field = "nome")
	{
		$selfies = new selfies_model();
		$selfies->set_field(array($key, $field));
		$selfies->set_filter($filters);
		$selfies->load_data();
		$out = array();
		foreach ($selfies->data as $value) {
			$out[$value[$key]] = $value[preg_replace("/^.+ as (.+)$/", "$1", $field)];
		}
		return $out;
	}

	private function filter($info)
	{
		$done = array();
		$filter = array(" idx > 0 ");
		if (isset($info["get"]["filter_name"]) && !empty($info["get"]["filter_name"])) {
			$done["filter_name"] = $info["get"]["filter_name"];
			$filter["filter_name"] = " nome like '%" . $info["get"]["filter_name"] . "%' ";
		}
		if (isset($info["get"]["filter_image"]) && !empty($info["get"]["filter_image"])) {
			$done["filter_image"] = $info["get"]["filter_image"];
			$filter["filter_image"] = " image like '%" . $info["get"]["filter_image"] . "%' ";
		}
		if (isset($info["get"]["filter_tutor"]) && !empty($info["get"]["filter_tutor"])) {
			$done["filter_tutor"] = $info["get"]["filter_tutor"];
			$filter["filter_tutor"] = " created_by like '%" . $info["get"]["filter_tutor"] . "%' ";
		}
		if (isset($info["get"]["filter_image"]) && !empty($info["get"]["filter_image"])) {
			$done["filter_image"] = $info["get"]["filter_image"];
			$filter["filter_image"] = " image like '%" . $info["get"]["filter_image"] . "%' ";
		}
		if (isset($info["get"]["filter_image"]) && !empty($info["get"]["filter_image"])) {
			$done["filter_image"] = $info["get"]["filter_image"];
			$filter["filter_image"] = " image like '%" . $info["get"]["filter_image"] . "%' ";
		}
		if (isset($info["get"]["filter_image"]) && !empty($info["get"]["filter_image"])) {
			$done["filter_image"] = $info["get"]["filter_image"];
			$filter["filter_image"] = " image like '%" . $info["get"]["filter_image"] . "%' ";
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

		$selfies = new selfies_model();

		$selfies->set_field(array(" idx ", " nome ", " image ", " raca ", " sexo ", " idade ", " caracteristica ", " active ", "created_at", "created_by"));

		if ( ! in_array( $info["format"] , array( ".json" , ".xls" ) ) ) {
			$selfies->set_paginate(array($info["sr"], $paginate));
		} else {
			$selfies->set_paginate(array(0, 900000));
		}
		//furniture/upload/lovers/selfies/3de6e7.png
		$selfies->set_filter($filter);
		$selfies->load_data();	
	
		$selfies->join( "users",'users',array("idx"=>"created_by"),null,array("idx","first_name", "cpf", "mail", "position", "uf"));
		$selfies->attach_son("users" , array("distributors") );
		$selfies->attach(array("votes"), true);
		$data = $selfies->data;
		$total = $selfies->con->result($selfies->con->select(" ifnull( count( idx ) , 0 ) as s ", " selfies ", " where " . implode(" and ", $filter)), "s", 0);
		//print_pre($data, true);
		switch ($info["format"]) {
			case ".xls":
				$name = "Relatorio_de_Selfies" .  date("d-m-Y-H:s") ; 
				require_once( constant("cRootServer_APP") . '/inc/lib/PHPExcel-1.8/Classes/PHPExcel.php' ) ;
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("HSOL")
					->setLastModifiedBy("HSOL")
					->setTitle("Relatorio_de_Selfies")
					->setSubject("Relatorio_de_Selfies")
					->setDescription("Relatorio_de_Selfies")
					->setKeywords("Relatorio_de_Selfies")
					->setCategory("Relatorio_de_Selfies");

				$objPHPExcel->setActiveSheetIndex(0)->setTitle('Relatorio_de_Selfies');
				$x_in = 1 ;

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'. $x_in , 'qtd_votos' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B'. $x_in , 'pet_nome' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C'. $x_in , 'pet_raca' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D'. $x_in , 'tutor_nome' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'. $x_in , 'tutor_cpf' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F'. $x_in , 'tutor_email' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'G'. $x_in , 'tutor_cargo' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'H'. $x_in , 'tutor_estado' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'I'. $x_in , 'distribuidora' );
				foreach( $data as $k => $v ){
					$x_in++;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'. $x_in , isset($v["votes_attach"][0]) ? count($v["votes_attach"]) : "-");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B'. $x_in , $v["nome"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C'. $x_in , $v["raca"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D'. $x_in , isset($v["users_attach"][0]) ? $v["users_attach"][0]["first_name"] : "-" );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'. $x_in , isset($v["users_attach"][0]) ? $v["users_attach"][0]["cpf"] : "-" );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F'. $x_in , isset($v["users_attach"][0]) ? $v["users_attach"][0]["mail"] : "-" );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'G'. $x_in , isset($v["users_attach"][0]) ? $v["users_attach"][0]["position"] : "-" );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'H'. $x_in , isset($v["users_attach"][0]) ? $v["users_attach"][0]["uf"] : "-" );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'I'. $x_in ,isset( $v["users_attach"][0]["distributors_attach"][0]) ? $v["users_attach"][0]["distributors_attach"][0]["name"] : "-" );
				}
				$objPHPExcel->setActiveSheetIndex(0);
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'. $name .'.xlsx"');
				
				header('Cache-Control: max-age=0');
				header('Cache-Control: max-age=1');
				header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
				header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
				header ('Cache-Control: cache, must-revalidate');
				header ('Pragma: public');
				$objWriter->setIncludeCharts(TRUE);
				$objWriter->save('php://output');
				$objWriter->setOffice2003Compatibility(true);
				$objPHPExcel->disconnectWorksheets();
				$objPHPExcel->garbageCollect();
				unset($objPHPExcel);
				exit();
			break;
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
				$page = 'selfies';
				$form = array(
					"done" => rawurlencode(!empty($done) ? set_url($GLOBALS["selfies_url"], $done) : $GLOBALS["selfies_url"]), "pattern" => array(
						"selfie" => $GLOBALS["newselfies_url"], "action" => $GLOBALS["selfie_url"], "search" => !empty($info["get"]) ? set_url($GLOBALS["selfies_url"], $info["get"]) : $GLOBALS["selfies_url"]
					)
				);
				include(constant("cRootServer") . "ui/common/header.inc.php");
				include(constant("cRootServer") . "ui/common/head.inc.php");
				include(constant("cRootServer") . "ui/page/selfies.php");
				include(constant("cRootServer") . "ui/common/footer.inc.php");
				print('<script>' . "\n");
				print('    data_selfies_json = {' . "\n");
				print('        url: "' . $GLOBALS["selfies_url"] . '.json"' . "\n");
				print('        , data: ' . json_encode($done) . "\n");
				print('        , template: ""' . "\n");
				print('        , page: 1' . "\n");
				print('    }' . "\n");
				include(constant("cRootServer") . "furniture/js/add/selfies.js");
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
			$selfies = new selfies_model();
			$selfies->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$selfies->load_data();
			$selfies->attach(array("votes"), true);
			$data = current($selfies->data);

			$form = array(
				"url" => sprintf($GLOBALS["selfie_url"], $info["idx"])
			);
		} else {
			$data = array();
			$form = array(
				"url" => $GLOBALS["newselfies_url"]
			);
		}

		$page = 'selfie';
		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/selfie.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		print("<script>");
		print('$("button[name=\'btn_back\']").bind("click", function(){');
		print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["selfies_url"]) . '" ');
		print('})' . "\n");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function save($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}
		$selfies = new selfies_model();

		if (isset($info["idx"]) && (int)$info["idx"] > 0) {
			$selfies->set_filter(array(" idx = '" . $info["idx"] . "' "));
		} else {
			$info["post"]["slug"] = generate_slug($info["post"]["idx"]);
		}

		if( isset( $_FILES[ "image" ] ) && is_file( $_FILES[ "image" ]["tmp_name"] ) ){
      $name = preg_replace('/(.+)(....)$/',"$2",$_FILES[ "image" ]["name"]);
      $file = "furniture/upload/lovers/selfies/" . generate_key(6) . $info["post"]["slug"] . $name ;
      if( ! file_exists( dirname( constant("cRootServer") . $file ) ) ){
        mkdir( dirname( constant("cRootServer") . $file ) , true );
      }
      if( file_exists( constant("cRootServer") . $file ) ){
        unlink( constant("cRootServer") . $file );
      }
      move_uploaded_file( $_FILES[ "image" ]["tmp_name"] , constant("cRootServer") . $file );
      $info["post"]["image"] = $file ;
    } 

		$selfies->populate($info["post"]);
		$selfies->save();

		if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
			$info["idx"] = $selfies->con->insert_id;
		}

		 $selfies->save_attach($info, array("profiles"));

		if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
			basic_redir($info["post"]["done"]);
		} else {
			basic_redir($GLOBALS["selfies_url"]);
		}
	}
}
