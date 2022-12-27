<?php
class musics_pets_controller
{
	public static function data4select($key = "idx", $filters = array(" active = 'yes' "), $field = "nome")
	{
		$musics = new musics_model();
		$musics->set_field(array($key, $field));
		$musics->set_filter($filters);
		$musics->load_data();
		
		$out = array();
		foreach ($musics->data as $value) {
			$out[$value[$key]] = $value[preg_replace("/^.+ as (.+)$/", "$1", $field)];
		}
		return $out;
	}

	private function filter($info)
	{
		$done = array();
		$filter = array(" active = 'yes' ");
		if (isset($info["get"]["filter_banda"]) && !empty($info["get"]["filter_banda"])) {
			$done["filter_banda"] = $info["get"]["filter_banda"];
			$filter["filter_banda"] = " banda like '%" . $info["get"]["filter_banda"] . "%' ";
		}		
		if (isset($info["get"]["filter_music"]) && !empty($info["get"]["filter_music"])) {
			$done["filter_music"] = $info["get"]["filter_music"];
			$filter["filter_music"] = " music like '%" . $info["get"]["filter_music"] . "%' ";
		}
		if (isset($info["get"]["filter_name"]) && !empty($info["get"]["filter_name"])) {
			$done["filter_name"] = $info["get"]["filter_name"];
			$filter["filter_name"] = " created_by like '%" . $info["get"]["filter_name"] . "%' ";
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

		$musics = new musics_model();

		$musics->set_field(array(" idx " , " created_at ", " created_by ", " modified_at ", " modified_by ", " removed_at ", " active ", " slug ",  " music ", " banda "));

		if ( ! in_array( $info["format"] , array( ".json" , ".xls" ) ) ) {
			$musics->set_paginate(array($info["sr"], $paginate));
		} else {
			$musics->set_paginate(array(0, 900000));
		}
		
		$musics->set_filter($filter);
		$musics->load_data();
		$musics->join( "users",'users',array("idx"=>"created_by"),null,array("idx","first_name", "cpf", "mail", "position", "uf"));
		
		
		$data = $musics->data;
		$total = $musics->con->result($musics->con->select(" ifnull( count( idx ) , 0 ) as s ", " musics ", " where " . implode(" and ", $filter)), "s", 0);
		switch ($info["format"]) {
			case ".xls":
				$name = "Relatório_de_Musicas" .  date("d-m-Y-H:s") ; 
				require_once( constant("cRootServer_APP") . '/inc/lib/PHPExcel-1.8/Classes/PHPExcel.php' ) ;
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("HSOL")
					->setLastModifiedBy("HSOL")
					->setTitle("Relatório_de_Musicas")
					->setSubject("Relatório_de_Musicas")
					->setDescription("Relatório_de_Musicas")
					->setKeywords("Relatório_de_Musicas")
					->setCategory("Relatório_de_Musicas");

				$objPHPExcel->setActiveSheetIndex(0)->setTitle('Relatório_de_Musicas');
				$x_in = 1 ;

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'. $x_in , 'Usuario' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B'. $x_in , 'Nome da Musica' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C'. $x_in , 'Nome da Banda' );
				foreach( $data as $k => $v ){
					$x_in++;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'. $x_in , isset($v["users_attach"][0]) ? $v["users_attach"][0]["first_name"] : "-" );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B'. $x_in , $v["music"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C'. $x_in , $v["banda"] );
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
				$page = 'musics';
				
				include(constant("cRootServer") . "ui/common/header.inc.php");
				include(constant("cRootServer") . "ui/common/head.inc.php");
				include(constant("cRootServer") . "ui/page/musics.php");
				include(constant("cRootServer") . "ui/common/footer.inc.php");
				print('<script>' . "\n");
				print('    data_musics_json = {' . "\n");
				print('        url: "' . $GLOBALS["musics_url"] . '.json"' . "\n");
				print('        , data: ' . json_encode($done) . "\n");
				print('        , template: ""' . "\n");
				print('        , page: 1' . "\n");
				print('    }' . "\n");
				include(constant("cRootServer") . "furniture/js/add/musics.js");
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
			$musics = new musics_model();
			$musics->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$musics->load_data();
		
			$data = current($musics->data);

			$form = array(
				"url" => sprintf($GLOBALS["music_url"], $info["idx"])
			);
		} else {
			$data = array();
			$form = array(
				"url" => $GLOBALS["newmusics_url"]
			);
		}

		$page = 'selfie';
		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/music.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		print("<script>");
		print('$("button[name=\'btn_back\']").bind("click", function(){');
		print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["musics_url"]) . '" ');
		print('})' . "\n");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function save($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}
		$musics = new musics_model();

		if (isset($info["idx"]) && (int)$info["idx"] > 0) {
			$musics->set_filter(array(" idx = '" . $info["idx"] . "' "));
		} else {
			$info["post"]["slug"] = generate_slug($info["post"]["idx"]);
		} 

		$musics->populate($info["post"]);
		$musics->save();

		if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
			$info["idx"] = $musics->con->insert_id;
		}

		if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
			basic_redir($info["post"]["done"]);
		} else {
			basic_redir($GLOBALS["musics_url"]);
		}
	}
}
