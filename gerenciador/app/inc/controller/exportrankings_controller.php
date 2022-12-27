<?php
class exportrankings_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    $users = new users_model();
    $users->set_field(array($key, $field));
    $users->set_filter($filters);
    $users->load_data();
    $out = array();
    foreach ($users->data as $value) {
      $out[$value[$key]] = $value[$field];
    }
    return $out;
  }

  private function filter($info)
  {
    $done = array();
    $filter = array("active = 'yes' ");

    if (isset($info["get"]["filter_name"]) && !empty($info["get"]["filter_name"])) {
      $done["filter_name"] = $info["get"]["filter_name"];
      $filter["filter_name"] = " concat_ws(' ' , first_name , last_name ) like '%" . $info["get"]["filter_name"] . "%' ";
    }

    if (isset($info["get"]["filter_cpf"]) && !empty($info["get"]["filter_cpf"])) {
      $done["filter_cpf"] = $info["get"]["filter_cpf"];
      $filter["filter_cpf"] = " cpf like '%" . $info["get"]["filter_cpf"] . "%' ";
    }

     if (isset($info["get"]["filter_period"]) && !empty($info["get"]["filter_period"])) {

       $done["filter_period"] = $info["get"]["filter_period"];

    //   switch ($info["get"]["filter_period"]) {
    //     case 'one_quarterly':
    //       $start = date("Y-m-d H:i:s", strtotime("01-01-2022 00:00:00"));
    //       $end = date("Y-m-d H:i:s", strtotime("31-03-2022 23:59:59"));

    //       $filter["filter_period"] = " mes >= '" . $start . "' and mes <= '" . $end . "' ";
    //       break;
    //     case 'two_quarterly':
    //       $start = date("Y-m-d H:i:s", strtotime("01-04-2022 00:00:00"));
    //       $end = date("Y-m-d H:i:s", strtotime("31-06-2022 23:59:59"));

    //       $filter["filter_period"] = " mes >= '" . $start . "' and mes <= '" . $end . "' ";
    //       break;
    //     case 'three_quarterly':
    //       $start = date("Y-m-d H:i:s", strtotime("01-07-2022 00:00:00"));
    //       $end = date("Y-m-d H:i:s", strtotime("31-09-2022 23:59:59"));

    //       $filter["filter_period"] = " mes >= '" . $start . "' and mes <= '" . $end . "' ";
    //       break;
    //     case 'four_quarterly':
    //       $start = date("Y-m-d H:i:s", strtotime("01-10-2022 00:00:00"));
    //       $end = date("Y-m-d H:i:s", strtotime("31-12-2022 23:59:59"));

    //       $filter["filter_period"] = " mes >= '" . $start . "' and mes <= '" . $end . "' ";
    //       break;
    //     default:
    //       $start = date("Y-m-d H:i:s", strtotime("01-01-2022 00:00:00"));
    //       $filter["filter_period"] = " mes >= '" . $start . "' ";
    //       break;
    //   }
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

    $fields = array(
      " u.idx " 
      , " concat_ws(' ' , u.first_name , u.last_name ) as nome "
      , " u.cod_mtrix "
      , " u.mail "
      , " u.cpf "
      , " u.position as cargo "
      , " d.name as distribuidora "
      , " g.name as nome_meta "
      , " g.points as valor_realizado "
      , " r.points as valor_meta "
      , " g.tipo "
      , " g.mes "
    ) ;    
    $table = array(
      " users u " ,
      " users_realtargets ur " , 
      " users_goals ug " , 
      " goals g " ,
      " realtargets r ",
      " users_distributors ud " , 
      " distributors d "
    ) ;
    $where = array(
      " u.active = 'yes' "
      , " ur.active = 'yes' "
      , " ug.active = 'yes' "
      , " r.active = 'yes' "
      , " g.active = 'yes' "
      , " d.active = 'yes' "
      , " ud.active = 'yes' "
      , " d.idx = ud.distributors_id "
      , " u.idx = ud.users_id "
      , " u.idx = ur.users_id "
      , " u.idx = ug.users_id "
      , " r.idx = ur.realtargets_id "
      , " g.idx = ug.goals_id "
      , " g.mes = r.mes "
      , " g.name = r.name "
    ) ;


    $filter_sub = " and active = 'yes' " ;
    $filter_respostas = " and active = 'yes' " ;
    if (isset($info["get"]["filter_period"]) && !empty($info["get"]["filter_period"])) {
      $filter_sub .= " and mes = '" . (int)$info["get"]["filter_period"] . "' " ; 
      $filter_respostas .= " and month( created_at ) = '" . $info["get"]["filter_period"] . "' " ; 
    }
    else{
      basic_redir( set_url($GLOBALS["ranking_exports_url"], array( "filter_period" => sprintf( "%02d" , date("m") ) ) ) );

    }

    $data = array();
    if (in_array($info["format"], array( ".xls"))) {
      $users->set_paginate(array(0, 90000000));
      $users->set_field(array("idx", "first_name", "last_name", "cpf","position","regional"));
      $users->set_filter($filter);
      $users->load_data();
      $users->attach(array("profiles","distributors"), false , null , array("idx","name"));
      $users->attach(array("goals"), false, $filter_sub , array(" created_at ", " name ", " points ", " tipo ", "type_front", "mes"));
      $users->attach(array("realtargets"), false, $filter_sub , array( "name", "points", "tipo" , "mes"));
      $users->join("respostas", "respostas", array("created_by" => "idx"), $filter_respostas , array(" idx ", " created_at ", " name ", "pontos", "active"));
      $users->attach_son("respostas", array("quizes"), true, "and active = 'yes' ", null);
      $data = $users->data;
    }

    /*$array = array(
      8 => array(
        "start" => date("Y-m-d H:i:s", strtotime("01-08-2022 00:00:00")),
        "end" => date("Y-m-d H:i:s", strtotime("31-08-2022 23:59:59")),
        "data" => array(),
        "tipo" => array()
      )
      , 9 => array(
        "start" => date("Y-m-d H:i:s", strtotime("01-09-2022 00:00:00")),
        "end" => date("Y-m-d H:i:s", strtotime("30-09-2022 23:59:59")),
        "data" => array(),
        "tipo" => array()
      )
      , 10 => array(
        "start" => date("Y-m-d H:i:s", strtotime("01-10-2022 00:00:00")),
        "end" => date("Y-m-d H:i:s", strtotime("31-10-2022 23:59:59")),
        "data" => array(),
        "tipo" => array()
      )
      , 11 => array(
        "start" => date("Y-m-d H:i:s", strtotime("01-11-2022 00:00:00")),
        "end" => date("Y-m-d H:i:s", strtotime("30-11-2022 23:59:59")),
        "data" => array(),
        "tipo" => array()
      )
      , 12 => array(
        "start" => date("Y-m-d H:i:s", strtotime("01-12-2022 00:00:00")),
        "end" => date("Y-m-d H:i:s", strtotime("31-12-2022 23:59:59")),
        "data" => array(),
        "tipo" => array()
      )
    );*/

    //$dic_type_front = goalstypes_controller::data4select("slug", array(" active = 'yes' "), "dic_type_front");


    /*
    if (isset($users->data[0]["goals_attach"][0])) {
      foreach ($users->data[0]["goals_attach"] as $k => $d) {
        $current_data = $d["mes"];
        foreach (array_keys($array) as $x) {
          if ($current_data >= $array[$x]["start"] && $current_data <= $array[$x]["end"]) {
            $kkk = isset($dic_type_front[ $d["type_front"] ]) ? $dic_type_front[$d["type_front"]] : "bonus";
            if (!isset($array[$x]["data"][$kkk])) {
              $array[$x]["data"][$kkk] = array(
                "month" => $x,
                "type_front" => $kkk,
                "name" => $d["tipo"],
              );
            }
            $array[$x]["data"][$kkk]["infos"][] = array(
              "name" => $d["name"],
              "points" => $d["points"]
            );
          }
        }
      }
    }

    if (isset($users->data[0]["respostas_attach"][0])) {
      foreach ($users->data[0]["respostas_attach"] as $k => $d) {
        $current_data = $d["created_at"];
        foreach (array_keys($array) as $x) {
          if ($current_data >= $array[$x]["start"] && $current_data <= $array[$x]["end"]) {
            if (!isset($array[$x]["data"]["pontuacoes-bonus"])) {
              $array[$x]["data"]["pontuacoes-bonus"] = array(
                "month" => $x,
                "name" => $d["quizes_attach"][0]["name"],
                "pontos" => $d["pontos"],
                "type_front" => "pontuacoes-bonus",
              );
            }
            $array[$x]["data"]["pontuacoes-bonus"]["infos"][] = array(
              "name" =>  $d["quizes_attach"][0]["name"],
              "points" => $d["pontos"]
            );
          }
        }
      }
    }
    */

    $total = 0;

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
      case ".xls":
        $name = "Planilha-de-Metas-e-Bonus-" .  date("d-m-Y-H:s");

        require_once(constant("cRootServer_APP") . '/inc/lib/PHPExcel-1.8/Classes/PHPExcel.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("HSOL")
          ->setLastModifiedBy("HSOL")
          ->setTitle("Planilha-de-Metas-e-Bonus")
          ->setSubject("Planilha-de-Metas-e-Bonus")
          ->setDescription("Planilha-de-Metas-e-Bonus")
          ->setKeywords("Planilha-de-Metas-e-Bonus")
          ->setCategory("Planilha-de-Metas-e-Bonus");

        $objPHPExcel->setActiveSheetIndex(0)->setTitle('Planilha-de-Metas-e-Bonus');
        $x_in = 1;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x_in, 'Nome Completo');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $x_in, 'CPF');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x_in, 'Perfil');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $x_in, 'Cargo');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $x_in, 'Distribuidora');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $x_in, 'Regional');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $x_in, 'Tipo de Meta e Bônus');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $x_in, 'Pontos');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $x_in, 'Período');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $x_in, 'Valor Meta');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $x_in, 'Valor Realizado');

        foreach ($data as $k => $v) {
          $goals = array();
          if (isset($v["goals_attach"][0])) {
            foreach ($v["goals_attach"] as $m => $goal) {
              $goals[ $goal["name"] ][ $goal["mes"] ] = $goal["points"];
            }
          }
          if (isset($v["realtargets_attach"][0])) {
            foreach ($v["realtargets_attach"] as $m => $goal) {
              $realizado = isset( $goals[ $goal["name"] ][ $goal["mes"] ] ) ? $goals[ $goal["name"] ][ $goal["mes"] ] : 0 ;
              $x_in++;
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x_in, $v["first_name"] . ' ' . $v["last_name"]);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $x_in, $v["cpf"]);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x_in, isset( $v["profiles_attach"][0] ) ? $v["profiles_attach"][0]["name"] : "-" );
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $x_in, $v["position"]);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $x_in, isset( $v["distributors_attach"][0] ) ? $v["distributors_attach"][0]["name"] : "-");
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $x_in, isset( $v["regional"] ) ? $v["regional"] : "-");

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $x_in, "Meta - " . $goal["name"]);           
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $x_in, $GLOBALS["month_name"][ sprintf( "%02d" , $goal["mes"] ) ] ? $GLOBALS["month_name"][ sprintf( "%02d" , $goal["mes"] ) ] : "Todos" );

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $x_in, $goal["points"]);   
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $x_in, $realizado );  
            }
          }

          if (isset($v["respostas_attach"][0])) {
            foreach ($v["respostas_attach"] as $m => $resposta) {
              $x_in++;
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x_in, $v["first_name"] . ' ' . $v["last_name"]);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $x_in, $v["cpf"]);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x_in, isset( $v["profiles_attach"][0] ) ? $v["profiles_attach"][0]["name"] : "-" );
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $x_in, isset( $v["position"] ) ? $v["position"] : "-");
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $x_in, isset( $v["distributors_attach"][0] ) ? $v["distributors_attach"][0]["name"] : "-");
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $x_in, isset( $v["regional"] ) ? $v["regional"] : "-");

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $x_in, "Quiz - " . ( isset( $resposta["quizes_attach"][0]["name"] ) ? $resposta["quizes_attach"][0]["name"] : "" ) );
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $x_in, $resposta["pontos"]);

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $x_in, $GLOBALS["month_name"][ preg_replace("/^.....(..).+/","$1", $resposta["created_at"] ) ] ? $GLOBALS["month_name"][ preg_replace("/^.....(..).+/","$1", $resposta["created_at"] ) ] : "Todos" );
            }
          }
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
      default:
        $page = 'ranking_exports';
        $form = array(
          "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["ranking_exports_url"], $done) : $GLOBALS["ranking_exports_url"]),
          "pattern" => array(
            "search" => !empty($info["get"]) ? set_url($GLOBALS["ranking_exports_url"], $info["get"]) : $GLOBALS["ranking_exports_url"],
            "export" => !empty($info["get"]) ? set_url($GLOBALS["ranking_exports_url"] . ".xls", $info["get"]) : $GLOBALS["ranking_exports_url"] . ".xls"
          )
        );
        include(constant("cRootServer") . "ui/common/header.inc.php");
        include(constant("cRootServer") . "ui/common/head.inc.php");
        include(constant("cRootServer") . "ui/page/ranking_exports.php");
        include(constant("cRootServer") . "ui/common/footer.inc.php");
        include(constant("cRootServer") . "ui/common/list_actions.php");
        print('<script>' . "\n");
        print('    data_rankingexports_json = {' . "\n");
        print('        url: "' . $GLOBALS["ranking_exports_url"] . '.json"' . "\n");
        print('        , data: ' . json_encode($done) . "\n");
        print('        , template: ""' . "\n");
        print('        , page: 1' . "\n");
        print('    }' . "\n");
        include(constant("cRootServer") . "furniture/js/add/ranking_exports.js");
        print('</script>' . "\n");
        include(constant("cRootServer") . "ui/common/foot.inc.php");
        break;
    }
  }
}
