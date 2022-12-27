<?php
class goalsimports_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    $goals = new goalsimports_model();
    $goals->set_field(array($key, $field));
    $goals->set_filter($filters);
    $goals->load_data();
    $out = array();
    foreach ($goals->data as $value) {
      $out[$value[$key]] = $value[$field];
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
    return array($done, $filter);
  }

  public function display($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    $paginate = 10;

    list($done, $filter) = $this->filter($info);

    $imports_goals = new goalsimports_model();

    if ($info["format"] != ".json") {
      $imports_goals->set_paginate(array($info["sr"], $paginate));
    } else {
      $imports_goals->set_paginate(array(0, 900000));
    }

    $imports_goals->set_filter($filter);
    $imports_goals->load_data();
    $data = $imports_goals->data;

    $total = $imports_goals->con->result($imports_goals->con->select(" ifnull( count( idx ) , 0 ) as s ", " goalsimports ", " where " . implode(" and ", $filter)), "s", 0);
    switch ($info["format"]) {
      case ".json":
        header('Content-type: application/json');
        echo json_encode(
          array(
            "total" => array("total" => $total), "row" => $data
          )
        );
        break;
      case ".xls":
        $name = "Planilha-de-metas-" .  date("d-m-Y-H:s");
        $goalsTypes = goalstypes_controller::data4select("idx", array(" active = 'yes' "), "name");
        $goalsList = implode(", ", array_values($goalsTypes));

        require_once(constant("cRootServer_APP") . '/inc/lib/PHPExcel-1.8/Classes/PHPExcel.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("HSOL")
          ->setLastModifiedBy("HSOL")
          ->setTitle("Planilha-de-metas")
          ->setSubject("Planilha-de-metas")
          ->setDescription("Planilha-de-metas")
          ->setKeywords("Planilha-de-metas")
          ->setCategory("Planilha-de-metas");

        $objPHPExcel->setActiveSheetIndex(0)->setTitle('Planilha-de-metas');
        $x_in = 1;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x_in, 'Nome');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $x_in, 'CPF');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x_in, 'Tipo');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $x_in, 'Pontuação');

        $col_count = 3;
        for ($i = 2; $i <= $col_count; $i++) {
          $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getDataValidation();
          $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
          $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
          $objValidation->setAllowBlank(false);
          $objValidation->setShowInputMessage(true);
          $objValidation->setShowErrorMessage(true);
          $objValidation->setShowDropDown(true);
          $objValidation->setErrorTitle('Input error');
          $objValidation->setError('Value is not in list.');
          $objValidation->setPromptTitle('Tipos de Metas');
          $objValidation->setPrompt('Por favor, escolha um valor dessa lista.');
          $objValidation->setFormula1('"' . $goalsList . '"');
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
        $page = 'imports_goals';
        $form = array(
          "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["goals_imports_url"], $done) : $GLOBALS["goals_imports_url"]), "pattern" => array(
            "new" => $GLOBALS["newgoal_import_url"], "action" => $GLOBALS["goal_import_url"], "search" => !empty($info["get"]) ? set_url($GLOBALS["goals_imports_url"], $info["get"]) : $GLOBALS["goals_imports_url"]
          )
        );
        include(constant("cRootServer") . "ui/common/header.inc.php");
        include(constant("cRootServer") . "ui/common/head.inc.php");
        include(constant("cRootServer") . "ui/page/imports_goals.php");
        include(constant("cRootServer") . "ui/common/footer.inc.php");
        print('<script>' . "\n");
        print('    data_goalsimports_json = {' . "\n");
        print('        url: "' . $GLOBALS["goals_imports_url"] . '.json"' . "\n");
        print('        , data: ' . json_encode($done) . "\n");
        print('        , template: ""' . "\n");
        print('        , page: 1' . "\n");
        print('    }' . "\n");
        include(constant("cRootServer") . "furniture/js/add/goals_imports.js");
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
      $import_goals = new goalsimports_model();
      $import_goals->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $import_goals->load_data();
      $import_goals->join("goals", "goals", array("goalsimports_id" => "idx"));
      $import_goals->attach_son( "goals" , array("users") , true );
      $data = current($import_goals->data);

      $form = array(
        "url" => sprintf($GLOBALS["goal_import_url"], $info["idx"])
      );
    } else {
      $data = array();
      $form = array(
        "url" => $GLOBALS["previewimportgoals_url"],
        "new" => $GLOBALS["newgoal_import_url"]
      );
    }

    $page = 'import_goals';
    include(constant("cRootServer") . "ui/common/header.inc.php");
    include(constant("cRootServer") . "ui/common/head.inc.php");
    include(constant("cRootServer") . "ui/page/import_goals.php");
    include(constant("cRootServer") . "ui/common/footer.inc.php");
    print("<script>");
    print('$("button[name=\'btn_back\']").bind("click", function(){');
    print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["goals_imports_url"]) . '" ');
    print('})' . "\n");
    print('</script>' . "\n");
    include(constant("cRootServer") . "ui/common/foot.inc.php");
  }

  public function preview($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    $form = array(
      "url" => $GLOBALS["previewimportgoals_url"],
      "new" => $GLOBALS["newgoal_import_url"]
    );

    if (isset($_FILES["plan"]) && is_file($_FILES["plan"]["tmp_name"])) {
      $d = preg_split("/\./", $_FILES["plan"]["name"]);
      $extension = $d[count($d) - 1];

      $extension_permited = ["xls", "xlsx"];

      if (array_search($extension, $extension_permited) >= 0) {

        $name = generate_slug(preg_replace("/\." . $extension . "$/", "", $_FILES["plan"]["name"]));

        $extension = date("YmdHis") . "." . $extension;
        $file = "furniture/upload/metas/planilhas/" . $name . $extension;

        if (!file_exists(dirname(constant("cRootServer") . $file))) {
          mkdir(dirname(constant("cRootServer") . $file), 0777, true);
          chmod(dirname(constant("cRootServer") . $file), 0775);
        }
        if (file_exists(constant("cRootServer") . $file)) {
          unlink(constant("cRootServer") . $file);
        }

        move_uploaded_file($_FILES["plan"]["tmp_name"], constant("cRootServer") . $file);
        $info["post"]["plan"] = $file;

        require_once(constant("cRootServer_APP") . '/inc/lib/PHPExcel-1.8/Classes/PHPExcel.php');
        $excelReader = PHPExcel_IOFactory::createReaderForFile(constant("cRootServer") . $file);
        $excelObj = $excelReader->load(constant("cRootServer") . $file);
        $worksheet = $excelObj->getSheet(0);
        $lastRow = $worksheet->getHighestRow();

        $listUsers = array();

        $aprovado = true;

        for ($row = 2; $row <= $lastRow; $row++) {
          $cpf = preg_replace("/[^0-9]+?/", "",  $worksheet->getCell('B' . $row)->getValue());

          $boiler = new users_model();
          $boiler->set_filter(array(" cpf = '" . $cpf . "' "));
          $boiler->load_data();

          $listUsers[$row]["nome"] = $worksheet->getCell('A' . $row)->getValue();
          $listUsers[$row]["cpf"] = $cpf;
          $listUsers[$row]["tipo"] = $worksheet->getCell('C' . $row)->getValue();;
          $listUsers[$row]["pontuacao"] = $worksheet->getCell('D' . $row)->getValue();
          $listUsers[$row]["obs"] = "";

          if (!isset($boiler->data[0])) {
            $listUsers[$row]["obs"] .= " Usuário não encontrado na base de dados. Altere ou remova-o da lista. | ";

            $aprovado = false;
          }

          if (empty($listUsers[$row]["pontuacao"])) {
            $listUsers[$row]["obs"] .= " Valor não preenchido.";

            $aprovado = false;
          }
        }
        if ($aprovado == true) {
          $_SESSION["messages_app"]["success"][] = "Leitura efetuada, verifique os dados importados.";
        } else {
          $_SESSION["messages_app"]["alert"][] = "Leitura efetuada, verifique os erros importados.";
        }
      } else {
        $_SESSION["messages_app"]["warning"][] = "Extensão do Arquivo Inválida, permitido: .xls ou .xls .";
      }
    }

    $page = 'import_goals';
    include(constant("cRootServer") . "ui/common/header.inc.php");
    include(constant("cRootServer") . "ui/common/head.inc.php");
    include(constant("cRootServer") . "ui/page/import_goals.php");
    include(constant("cRootServer") . "ui/common/footer.inc.php");
    include(constant("cRootServer") . "ui/common/foot.inc.php");
  }

  public function save($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    $goalsimports = new goalsimports_model();
    $goalsimports->populate($info["post"]);
    $goalsimports->save();
    $info["post"]["goalsimports_idx"] = $goalsimports->con->insert_id;

    $listusers = unserialize(base64_decode($info["post"]["listuser"]));

    $list_goalstype = goalstypes_controller::data4select( "name" , array(" active = 'yes' ") ,"slug");

    foreach ($listusers as $k => $v) {
      $goals_type = new goalstypes_model();
      $goals_type->set_filter(array( " active = 'yes' " , " name = '" . $v["tipo"] . "' "));
      $goals_type->load_data();

      $goals = new goals_model();
      $goals->populate(
        array(
          "name" => $v["tipo"],
          "points" => $v["pontuacao"],
          "cpf" => $v["cpf"],
          "mes" => date("Y") . '-' . $info["post"]["month"] . "-01 00:00:00" ,
          "tipo" => $v["tipo"],
          "type_front" => isset( $list_goalstype[ $v["tipo"] ] ) ?  $list_goalstype[ $v["tipo"] ] : "-" ,
          "goalsimports_id" => $info["post"]["goalsimports_idx"]
        )
      );
      $goals->save();
      $info["idx"] = $goals->con->insert_id;

      $goals->save_attach(array("idx" => $info["idx"], "post" => array("users_id" =>  current(users_controller::data4select("idx", array(" cpf = '" . $v["cpf"] . "' "), "idx")))), array("users"), true);
    }

    if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
      basic_redir($info["post"]["done"]);
    } else {
      basic_redir($GLOBALS["goals_imports_url"]);
    }
  }
}
