<?php
class games_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    $users = new games_model();
    $users->set_field(array($key, $field));
    $users->set_filter($filters);
    $users->load_data();

    $key = preg_replace("/^(.+) as (.+)$/", "$2", $key);
    $field = preg_replace("/^(.+) as (.+)$/", "$2", $field);



    $out = array_column($users->data, $key, $field);
    return $out;
  }

  private function filter($info)
  {
    $done = array();
    $filter = array("active = 'yes' ", " finished = 'yes' ", "TIMEDIFF( modified_at , created_at) != '00:00:00' ");

    if (isset($info["get"]["filter_name"]) && !empty($info["get"]["filter_name"])) {
      $done["filter_name"] = $info["get"]["filter_name"];
      $filter["filter_name"] = " concat_ws(' ' , first_name , last_name ) like '%" . $info["get"]["filter_name"] . "%' ";
    }

    if (isset($info["get"]["filter_cpf"]) && !empty($info["get"]["filter_cpf"])) {
      $done["filter_cpf"] = $info["get"]["filter_cpf"];
      $filter["filter_cpf"] = " created_by in ( select users.idx from users where cpf like '%" . $info["get"]["filter_cpf"] . "%' ) ";
    }

    if (isset($info["get"]["filter_month_ref"]) && !empty($info["get"]["filter_month_ref"])) {
      $done["filter_month_ref"] = $info["get"]["filter_month_ref"];
      $filter["filter_month_ref"] = " DATE_FORMAT( end_at , '%Y%m' ) = '" . $info["get"]["filter_month_ref"] . "' ";
    }

    return array($done, $filter);
  }

  public function display($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    list($done, $filter) = $this->filter($info);

    $boilers = new games_model();

    $paginate = isset($info["get"]["paginate"]) && (int)$info["get"]["paginate"] > 20 ? $info["get"]["paginate"] : 20;

    if (!in_array($info["format"], array(".json", ".xls"))) {
      $boilers->set_paginate(array($info["sr"], $paginate));
    } else {
      $boilers->set_paginate(array(0, 900000));
    }

    $boilers->set_filter($filter);
    $boilers->set_field(array(
      " count( idx ) as qtd  ", " 0 as idx  ",  "min( ( TIMEDIFF( modified_at , created_at) ) ) as tempo ",  "created_by "
    ));
    $boilers->set_group(array("created_by"));
    $boilers->set_order(array(" min( TIME_TO_SEC( TIMEDIFF( modified_at , created_at) ) ) ", " count( idx ) "));
    $boilers->load_data();
    $boilers->join("users", "users", array("idx" => "created_by"), null, array("idx", "first_name", "last_name", "cpf"));

    $data = $boilers->data;

    $total = $boilers->con->result($boilers->con->select(" ifnull( count( idx ) , 0 ) as s ", " games ", " where " . implode(" and ", $filter)), "s", 0);

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
        $name = "Planilha-Jogo-da-Memoria-" .  date("d-m-Y-H:s");

        require_once(constant("cRootServer_APP") . '/inc/lib/PHPExcel-1.8/Classes/PHPExcel.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("HSOL")
          ->setLastModifiedBy("HSOL")
          ->setTitle("Planilha-Jogo-da-Memoria")
          ->setSubject("Planilha-Jogo-da-Memoria")
          ->setDescription("Planilha-Jogo-da-Memoria")
          ->setKeywords("Planilha-Jogo-da-Memoria")
          ->setCategory("Planilha-Jogo-da-Memoria");

        $objPHPExcel->setActiveSheetIndex(0)->setTitle('Planilha-Jogo-da-Memoria');
        $x_in = 1;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x_in, 'Nome Completo');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $x_in, 'CPF');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x_in, 'Quantidade de Movimentos');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $x_in, 'Tempo para Finalizar');

        foreach ($data as $k => $v) {
          $x_in++;
          if (isset($v["users_attach"][0])) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x_in, $v["users_attach"][0]["first_name"] . ' ' . $v["users_attach"][0]["last_name"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $x_in, $v["users_attach"][0]["cpf"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x_in, $v["qtd"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $x_in, $v["tempo"]);
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
        $page = 'Games';
        $form = array(
          "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["games_url"], $done) : $GLOBALS["games_url"]),
          "pattern" => array(
            "search" => !empty($info["get"]) ? set_url($GLOBALS["games_url"], $info["get"]) : $GLOBALS["games_url"],
            "export" => !empty($info["get"]) ? set_url($GLOBALS["games_url"] . ".xls", $info["get"]) : $GLOBALS["games_url"] . ".xls"
          )
        );
        include(constant("cRootServer") . "ui/common/header.inc.php");
        include(constant("cRootServer") . "ui/common/head.inc.php");
        include(constant("cRootServer") . "ui/page/memory-game/games.php");
        include(constant("cRootServer") . "ui/common/footer.inc.php");
        include(constant("cRootServer") . "ui/common/list_actions.php");
        print('<script>' . "\n");
        print('    data_games_json = {' . "\n");
        print('        url: "' . $GLOBALS["games_url"] . '.json"' . "\n");
        print('        , data: ' . json_encode($done) . "\n");
        print('        , template: ""' . "\n");
        print('        , page: 1' . "\n");
        print('    }' . "\n");
        include(constant("cRootServer") . "furniture/js/add/reports/games.js");
        print('</script>' . "\n");
        include(constant("cRootServer") . "ui/common/foot.inc.php");
        break;
    }
  }

  public function form($info)
  {
    //
  }

  public function save($info)
  {
    //
  }
}
