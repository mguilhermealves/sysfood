<?php
class respostas_controller
{
	public static function data4select($key = "idx", $filters = array(), $field = "name")
	{
		$boiler = new respostas_model();
		$boiler->set_field(array($key, $field));
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
		if (isset($info["get"]["filter_quiz_id"]) && !empty($info["get"]["filter_quiz_id"])) {
			$done["filter_quiz_id"] = $info["get"]["filter_quiz_id"];
			$filter["filter_quiz_id"] = " idx in ( select quizes_respostas.respostas_id from quizes_respostas where quizes_respostas.quizes_id = '" . $info["get"]["filter_quiz_id"] . "' ) ";
		}
		if (isset($info["get"]["filter_user_id"]) && !empty($info["get"]["filter_user_id"])) {
			$done["filter_user_id"] = $info["get"]["filter_user_id"];
			$filter["filter_user_id"] = " created_by = '" . $info["get"]["filter_user_id"] . "' ";
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
		$boiler = new respostas_model();
		$boiler->set_field(array("idx", " acertos " , " pontos ", " created_at ", " created_by "," resposta "));
		if( !in_array( $info["format"] , array( ".json" , ".xls" ) ) ) {
			$boiler->set_paginate(array($info["sr"], $paginate));
		} else {
			$boiler->set_paginate(array(0, 900000));
		}
		$boiler->set_filter($filter);
		$boiler->load_data();
		$boiler->attach(array("quizes"), true, null, array("idx", "name", "slug","questions"));
		$boiler->join("users", "users", array("idx" => "created_by"), null, array("idx", "first_name", "last_name","mail","cpf","position","regional","distribuidora","city","uf"));
		$boiler->attach_son("users" , array("profiles") );

		$data = $boiler->data;
		$total = $boiler->con->result($boiler->con->select(" ifnull( count( idx ) , 0 ) as s ", " respostas ", " where " . implode(" and ", $filter)), "s", 0);

		switch ($info["format"]) {
			case ".json":
				header('Content-type: application/json');
				echo json_encode(
					array(
						"total" =>  array("total" => $total), "row" => $data
					)
				);
			break;
			case ".xls":
				$perguntas = unserialize( $data[0]["quizes_attach"][0]["questions"] )["data"] ;
				//print_pre( $perguntas );
				//print_pre( $data , true );
				$name = "Relatorio_Respostas_Quiz" .  date("d-m-Y-H:s") ; 
				require_once( constant("cRootServer_APP") . '/inc/lib/PHPExcel-1.8/Classes/PHPExcel.php' ) ;
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("HSOL")
					->setLastModifiedBy("HSOL")
					->setTitle("Relatorio_Respostas_Quiz")
					->setSubject("Relatorio_Respostas_Quiz")
					->setDescription("Relatorio_Respostas_Quiz")
					->setKeywords("Relatorio_Respostas_Quiz")
					->setCategory("Relatorio_Respostas_Quiz");

				$objPHPExcel->setActiveSheetIndex(0)->setTitle('Relatorio_Respostas_Quiz');
				$x_in = 1 ;

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'. $x_in , 'CPF' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B'. $x_in , 'Nome' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C'. $x_in , 'Sobrenome' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D'. $x_in , 'E-mail' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'. $x_in , 'Cargo' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F'. $x_in , 'Regional' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'G'. $x_in , 'Distribuidora' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'H'. $x_in , 'Cidade' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'I'. $x_in , 'Estado' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'J'. $x_in , 'Perfil' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'K'. $x_in , 'Pontos' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'L'. $x_in , 'Acertos' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'M'. $x_in , 'Data da Resposta' );
				$r = 13 ;
				foreach( $perguntas as $k => $v ){
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( $GLOBALS["column_alpha"][ $r ] . $x_in , $v["pergunta"] );
					$r++;
				}

				foreach( $data as $k => $v ){
					$x_in++;
					$resposta = unserialize( $v['resposta'] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'. $x_in , $v['users_attach'][0]["cpf"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B'. $x_in , $v['users_attach'][0]["first_name"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C'. $x_in , $v['users_attach'][0]["last_name"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D'. $x_in , $v['users_attach'][0]["mail"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'. $x_in , $v['users_attach'][0]["position"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F'. $x_in , $v['users_attach'][0]["regional"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'G'. $x_in , $v['users_attach'][0]["distribuidora"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'H'. $x_in , $v['users_attach'][0]["city"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'I'. $x_in , $v['users_attach'][0]["uf"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'J'. $x_in , $v['users_attach'][0]["profiles_attach"][0]["name"] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'K'. $x_in , $v['pontos'] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'L'. $x_in , $v['acertos'] );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'M'. $x_in , $v['created_at'] );

					$r = 13 ;
					foreach( $perguntas as $s => $t ){
						$vvvv = isset( $resposta[ $s ] ) && isset( $perguntas[ $s ]["resposta"][ $resposta[ $s ] ] ) ? $perguntas[ $s ]["resposta"][ $resposta[ $s ] ]["text"] : "-" ;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue( $GLOBALS["column_alpha"][ $r ] . $x_in , $vvvv ) ;
						$r++;
					}
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
			default:
				$page = 'quiz_report';
				$form = array(
					"done" => rawurlencode(!empty($done) ? set_url($GLOBALS["quizresponse_url"], $done) : $GLOBALS["quizresponse_url"]), "pattern" => array(
						"new" => $GLOBALS["quizresponse_url"], "action" => $GLOBALS["quiz_url"], "search" => !empty($info["get"]) ? set_url($GLOBALS["quizresponse_url"], $info["get"]) : $GLOBALS["quizresponse_url"]
					)
				);
				include(constant("cRootServer") . "ui/common/header.inc.php");
				include(constant("cRootServer") . "ui/common/head.inc.php");
				include(constant("cRootServer") . "ui/page/quiz_result.php");
				include(constant("cRootServer") . "ui/common/footer.inc.php");
				print('<script>' . "\n");
				print('    quiz_results_json = {' . "\n");
				print('        url: "' . $GLOBALS["quizresponse_url"] . '.json"' . "\n");
				print('        , data: ' . json_encode($done) . "\n");
				print('        , template: ""' . "\n");
				print('        , page: 1' . "\n");
				print('    }' . "\n");
				include(constant("cRootServer") . "furniture/js/add/quiz_results.js");
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
			$quizes = new quizes_model();
			$quizes->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$quizes->load_data();
			$data = current($quizes->data);
			$data["questions"] = unserialize($data["questions"]);
			$form = array(
				"url" => sprintf($GLOBALS["quiz_url"], $info["idx"])
			);
		} else {
			$data = array();
			$form = array(
				"url" => $GLOBALS["newquiz_url"]
			);
		}
		$page = 'quiz';
		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/quiz_result.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		print("<script>");
		print('$("button[name=\'btn_back\']").bind("click", function(){');
		print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["quizes_url"]) . '" ');
		print('})' . "\n");
		include(constant("cRootServer") . "furniture/js/add/quiz.js");
		if (isset($data["questions"]["data"])) {
			$i = 1;
			foreach ($data["questions"]["data"] as $k => $v) {
				print("quiz.add_question({\n");
				print("    id_key : '" . $k . "'\n");
				print("    , num: '" . $i . "'\n");
				print("    , CORRECT: '" . $v["correct"] . "'\n");
				print("    , pergunta: '" . $v["pergunta"] . "'\n");
				print("    , target: $(\"#accordionFlushExample\")\n");
				print("});\n");
				foreach ($v["resposta"] as $r => $s) {
					print("quiz.add_resposta({\n");
					print("    id_key : '" . $k . "'\n");
					print("    , id : '" . $r . "'\n");
					print("    , checked: '" . ($v["correct"] == $r ? " x " : "") . "'\n");
					print("    , text: '" . $s["text"] . "'\n");
					print("    , correct: '" . ($v["correct"] == $r ? "yes" : "no") . "'\n");
					print("});\n");
				}
				$i++;
			}
		}
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}
	public function save($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}
		$quizes = new quizes_model();
		if (isset($info["idx"]) && (int)$info["idx"] > 0) {
			$quizes->set_filter(array(" idx = '" . $info["idx"] . "' "));
		} else {
			$info["post"]["slug"] = generate_slug($info["post"]["name"]);
		}

		$info["post"]["questions"] = serialize($info["post"]["questions"]);

		if (isset($_FILES["catalogo_file"]) && is_file($_FILES["catalogo_file"]["tmp_name"])) {
			$d = preg_split("/\./", $_FILES["catalogo_file"]["name"]);
			$extension = $d[count($d) - 1];
			$name = generate_slug(preg_replace("/\." . $extension . "$/", "", $_FILES["catalogo_file"]["name"]));
			$extension = date("YmdHis") . "." . $extension;
			$file = "furniture/upload/quiz/" . $name . $extension;
			if (file_exists(constant("cRootServer") . $file)) {
				unlink(constant("cRootServer") . $file);
			}
			move_uploaded_file($_FILES["catalogo_file"]["tmp_name"], constant("cRootServer") . $file);
			$info["post"]["catalogo"] = $file;
		}

		$quizes->populate($info["post"]);
		$quizes->save();
		if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
			$info["idx"] = $quizes->con->insert_id;
		}
		if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
			basic_redir($info["post"]["done"]);
		} else {
			basic_redir($GLOBALS["quizes_url"]);
		}
	}
}
