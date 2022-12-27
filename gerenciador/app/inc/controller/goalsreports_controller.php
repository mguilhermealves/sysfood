<?php
class goalsreports_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    //
  }

  private function filter($info)
  {
    $done = array();
    $filter = array("active = 'yes' ");

    $filter["isFilter"] = false;

    if (isset($info["get"]["filter_distributors"]) && !empty($info["get"]["filter_distributors"])) {
      $done["filter_distributors"] = $info["get"]["filter_distributors"];
      $filter["filter_distributors"] = $info["get"]["filter_distributors"];
      $filter["isFilter"] = true;
    } else {
      $filter["filter_distributors"] = '';
    }

    if (isset($info["get"]["filter_month"]) && !empty($info["get"]["filter_month"])) {
      $done["filter_month"] = $info["get"]["filter_month"];
      $filter["filter_month"] = $info["get"]["filter_month"];
      $filter["isFilter"] = true;
    } else {
      $filter["filter_month"] = '';
    }

    if (isset($info["get"]["filter_office"]) && !empty($info["get"]["filter_office"])) {
      $done["filter_office"] = $info["get"]["filter_office"];
      $filter["filter_office"] = $info["get"]["filter_office"];
      $filter["isFilter"] = true;
    } else {
      $filter["filter_office"] = '';
    }

    return array($done, $filter);
  }

  public function display($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    list($done, $filter) = $this->filter($info);

    if ($filter["isFilter"] == true) {
      $reports_products = $this->reports_products($filter);
    } else {
      $_SESSION["messages_app"]["warning"][] = "Adicione um ou mais campos para filtrar.";
    }

    $form = array(
      "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["goalsreports_url"], $done) : $GLOBALS["goalsreports_url"]),
      "pattern" => array(
        "search" => !empty($info["get"]) ? set_url($GLOBALS["goalsreports_url"], $info["get"]) : $GLOBALS["goalsreports_url"],
        "export" => !empty($info["get"]) ? set_url($GLOBALS["goalsreports_url"] . ".xls", $info["get"]) : $GLOBALS["goalsreports_url"] . ".xls"
      )
    );

    include(constant("cRootServer") . "ui/common/header.inc.php");
    include(constant("cRootServer") . "ui/common/head.inc.php");
    include(constant("cRootServer") . "ui/page/reports/goalsreports.php");
    include(constant("cRootServer") . "ui/common/footer.inc.php");
    include(constant("cRootServer") . "ui/common/list_actions.php");
    // print('<script>' . "\n");
    // print('    data_goalsreports_json = {' . "\n");
    // print('        url: "' . $GLOBALS["goalsreports_url"] . '.json"' . "\n");
    // print('        , data: ' . json_encode($done) . "\n");
    // print('        , template: ""' . "\n");
    // print('        , page: 1' . "\n");
    // print('    }' . "\n");
    // include(constant("cRootServer") . "furniture/js/add/goalsreports.js");
    // print('</script>' . "\n");
    include(constant("cRootServer") . "ui/common/foot.inc.php");
  }

  public function reports_products($info)
  {
    // print_pre($info, true);

    if (isset($info["filter_month"])) {
      $sql = '    SELECT  ';
      $sql .= '        vw_PRODUTOS.*, ';
      $sql .= '        IF(productsbase.type = "product_base", ';
      $sql .= '            "Base", ';
      $sql .= '            IF(productsbase.type = "product_launch", ';
      $sql .= '                "Lancamento", ';
      $sql .= '                "FORA SKU")) AS TIPO, ';
      $sql .= '        IF(CAST(vw_PRODUTOS.valor_realizado AS DECIMAL) > CAST(vw_PRODUTOS.valor_meta AS DECIMAL), ';
      $sql .= '            IF(productsbase.type = "product_base", ';
      $sql .= '                ' . 10 . ', ';
      $sql .= '                IF(productsbase.type = "product_launch", ';
      $sql .= '                    ' . 15 . ', ';
      $sql .= '                    CAST(vw_PRODUTOS.valor_realizado AS DECIMAL))), ';
      $sql .= '            ' . 0 . ') AS PONTOS, ';
      $sql .= '        IF(CAST(vw_PRODUTOS.valor_realizado AS DECIMAL) > CAST(vw_PRODUTOS.valor_meta AS DECIMAL), ';
      $sql .= '            (CAST(vw_PRODUTOS.valor_realizado AS DECIMAL) - CAST(vw_PRODUTOS.valor_meta AS DECIMAL)) * (IF(productsbase.type = "product_base", ';
      $sql .= '                ' . 2 . ', ';
      $sql .= '                IF(productsbase.type = "product_launch", ';
      $sql .= '                    ' . 5 . ', ';
      $sql .= '                    ' . 0 . '))), ';
      $sql .= '            ' . 0 . ') AS PONTOS_ADICIONAIS ';
      $sql .= '    FROM ';
      $sql .= '        vw_PRODUTOS, ';
      $sql .= '        goalstypes, ';
      $sql .= '        productsbase_goalstypes, ';
      $sql .= '        productsbase ';
      $sql .= '    WHERE ';
      $sql .= '        vw_PRODUTOS.mes = ' . (int)$info["filter_month"];
      $sql .= '            and vw_PRODUTOS.tipo = goalstypes.slug ';
      $sql .= '            and goalstypes.active = "yes" ';
      $sql .= '            and productsbase_goalstypes.goalstypes_id = goalstypes.idx ';
      $sql .= '            and productsbase_goalstypes.productsbase_id = productsbase.idx ';
      $sql .= '            and productsbase.active = "yes" ';
      $sql .= '            and productsbase_goalstypes.active = "yes" ';
      // $sql .= '            and vw_PRODUTOS.cargo = "' . $info["filter_office"] . '" ';
      // $sql .= '            and vw_PRODUTOS.distribuidora like "%' . $info["filter_distributors"] . '%" ';
      $sql .= '    GROUP BY vw_PRODUTOS.idx , vw_PRODUTOS.nome_meta; ';

      $sql2 = '    SELECT  ';
      $sql2 .= '        u.idx, ';
      $sql2 .= '        CONCAT_WS(" ", u.first_name, u.last_name) AS nome, ';
      $sql2 .= '        u.cod_mtrix as cod_mtrix, ';
      $sql2 .= '        u.mail as mail, ';
      $sql2 .= '        u.cpf as cpf, ';
      $sql2 .= '        u.position AS cargo, ';
      $sql2 .= '        d.name AS distribuidora, ';
      $sql2 .= '        r.name AS nome_meta, ';
      $sql2 .= '        r.points AS valor_meta, ';
      $sql2 .= '        g.points AS valor_realizado, ';
      $sql2 .= '        r.mes as mes, ';
      $sql2 .= '        g.tipo as tipo ';
      $sql2 .= '        , if( CAST( g.points as decimal) > CAST(  r.points as decimal) , ' . 10 . ',' . 0 . ' ) as PONTOS ';
      $sql2 .= '        , if(  ';
      $sql2 .= '            CAST( g.points as decimal) > CAST( r.points as decimal) ,  ';
      $sql2 .= '            ( CAST( g.points as decimal) - CAST( r.points as decimal) ) *  ' . 5 . ',' . 0 . ' )  as PONTOS_ADICIONAIS ';
      $sql2 .= '    FROM ';
      $sql2 .= '        users u, ';
      $sql2 .= '        users_distributors ud, ';
      $sql2 .= '        distributors d, ';
      $sql2 .= '        users_realtargets ur, ';
      $sql2 .= '        realtargets r, ';
      $sql2 .= '        users_goals ug, ';
      $sql2 .= '        goals g ';
      $sql2 .= '    WHERE ';
      $sql2 .= '        u.active = "yes" and d.active = "yes" ';
      $sql2 .= '            and g.active = "yes" ';
      $sql2 .= '            and r.active = "yes" ';
      $sql2 .= '            and ud.active = "yes" ';
      $sql2 .= '            and ur.active = "yes" ';
      $sql2 .= '            and ug.active = "yes" ';
      $sql2 .= '            and u.idx = ud.users_id ';
      $sql2 .= '            and d.idx = ud.distributors_id ';
      $sql2 .= '            and u.idx = ur.users_id ';
      $sql2 .= '            and r.idx = ur.realtargets_id ';
      $sql2 .= '            and u.idx = ug.users_id ';
      $sql2 .= '            and ur.users_id = ug.users_id ';
      $sql2 .= '            and g.idx = ug.goals_id ';
      $sql2 .= '            and r.mes = g.mes ';
      $sql2 .= '            and r.name = g.name ';
      $sql2 .= '            and r.cod_mtrix = u.cod_mtrix ';
      $sql2 .= '            and g.cpf = u.cpf ';
      // $sql2 .= '            and d.name like "%' . $info["filter_distributors"] . '%" ';
      // $sql2 .= '            and u.position = "' . $info["filter_office"] . '" ';
      $sql2 .= '            and r.name = "Positivacao" ';
      $sql2 .= '            and r.mes = ' . (int)$info["filter_month"];
      $sql2 .= '    GROUP BY u.idx , r.name , r.mes  ';

      $sql3 = '    SELECT  ';
      $sql3 .= '        u.idx ';
      $sql3 .= '        , concat_ws(" ", u.first_name , u.last_name) as Nome ';
      $sql3 .= '        , u.cod_mtrix as "COD-MTRIX" ';
      $sql3 .= '        , u.mail as EMAIL ';
      $sql3 .= '        , u.cpf as CPF ';
      $sql3 .= '        , u.position as CARGO ';
      $sql3 .= '        , d.name as DISTRIBUIDORA ';
      $sql3 .= '        , g.name ';
      $sql3 .= '        , 0 ';
      $sql3 .= '        , CAST( g.points as decimal) ';
      $sql3 .= '        , g.mes ';
      $sql3 .= '        , g.name ';
      $sql3 .= '        , "FORA SKU" as TIPO ';
      $sql3 .= '        , CAST( g.points as decimal)  as PONTOS ';
      $sql3 .= '        , 0  as PONTOS_ADICIONAIS ';
      $sql3 .= '    FROM  ';
      $sql3 .= '        users u ';
      $sql3 .= '        , users_distributors ud ';
      $sql3 .= '        , distributors d ';
      $sql3 .= '        , goals g ';
      $sql3 .= '    where ';
      $sql3 .= '        u.active = "yes" ';
      $sql3 .= '        and ud.active = "yes" ';
      $sql3 .= '        and d.active = "yes" ';
      $sql3 .= '        and g.active = "yes" ';
      $sql3 .= '        and g.cpf_clean = u.cpf ';
      $sql3 .= '        and g.mes = ' . (int)$info["filter_month"];
      $sql3 .= '        and ( not g.name in ( SELECT name FROM productsbase where month = ' . (int)$info["filter_month"] . ' ) ) ';
      // $sql3 .= '            and d.name like "%' . $info["filter_distributors"] . '%" ';
      // $sql3 .= '            and u.position = "' . $info["filter_office"] . '" ';
      $sql3 .= '        and u.idx = ud.users_id ';
      $sql3 .= '        and g.name != "Positivacao" ';
      $sql3 .= '        and d.idx = ud.distributors_id; ';

      $goals_model = new goals_model();
      $results = array(
        "PRODUTOS" => array(
          "CAMPOS" => array(
            "idx" => false, "nome" => "Nome", "cod_mtrix" => "Codigo Mtrix", "mail" => "E-mail", "cpf" => "CPF", "cargo" => "Cargo", "distribuidora" => "Distribuidora", "nome_meta" => "Nome Meta", "valor_meta" => "Valor Meta", "valor_realizado" => "Valor Realizado", "mes" => "Mês", "tipo" => "Tipo", "parent" => false, "TIPO" => "Tipo Produto", "PONTOS" => "Pontos", "PONTOS_ADICIONAIS" => "Pontos Adicionais"
          ), "DADOS" => $goals_model->con->results($goals_model->con->my_query($sql))
        ),
        "POSITIVACAO" => array(
          "CAMPOS" => array(
            "idx" => false, "nome" => "Nome", "cod_mtrix" => "Codigo Mtrix", "mail" => "E-mail", "cpf" => "CPF", "cargo" => "Cargo", "distribuidora" => "Distribuidora", "nome_meta" => "Nome Meta", "valor_meta" => "Valor Meta", "valor_realizado" => "Valor Realizado", "mes" => "Mês", "tipo" => "Tipo", "PONTOS" => "Pontos", "PONTOS_ADICIONAIS" => "Pontos Adicionais"
          ), "DADOS" => $goals_model->con->results($goals_model->con->my_query($sql2))
        ),
        "PRODUTO_FORA" => array(
          "CAMPOS" => array(
            "idx" => false, "Nome" => "Nome", "COD-MTRIX" => "Codigo Mtrix", "EMAIL" => "E-mail", "CPF" => "CPF", "CARGO" => "Cargo", "DISTRIBUIDORA" => "Distribuidora", "name" => "Nome Meta", "0" => false, "CAST( g.points as decimal)" => false, "mes" => "Mês", "TIPO" => "Tipo", "PONTOS" => "Pontos", "PONTOS_ADICIONAIS" => "Pontos Adicionais"
          ), "DADOS" => $goals_model->con->results($goals_model->con->my_query($sql3))
        )
      );

      $this->monted_excel($results);
    } else {
      $_SESSION["messages_app"]["warning"][] = "O campo mês não foi informado.";

      basic_redir($GLOBALS["goalsreports_url"]);
    }
  }

  public function monted_excel($results)
  {
    $name = "Relatorio-de-Metas-" .  date("d-m-Y-H:s");
    require_once(constant("cRootServer_APP") . '/inc/lib/PHPExcel-1.8/Classes/PHPExcel.php');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("HSOL")
      ->setLastModifiedBy("HSOL")
      ->setTitle("Relatorio-de-Metas")
      ->setSubject("Relatorio-de-Metas")
      ->setDescription("Relatorio-de-Metas")
      ->setKeywords("Relatorio-de-Metas")
      ->setCategory("Relatorio-de-Metas");

    $x_sheet = 0;
    foreach ($results as $kresult => $vresult) {
      $objPHPExcel->createSheet();
      $x_in = 1;

      $objPHPExcel->setActiveSheetIndex($x_sheet)->setTitle("Relatorio-de-" . $kresult);
      $x_colum = 0;
      foreach ($vresult["CAMPOS"] as $k => $v) {
        if ($v) {
          $objPHPExcel->setActiveSheetIndex($x_sheet)->setCellValue($GLOBALS["column_alpha"][$x_colum] . $x_in, $v);
          $x_colum++;
        }
      }

      $x_in = 1;
      foreach ($vresult["DADOS"] as $kDados => $vDados) {
        $x_in++;
        $x_colum = 0;
        foreach ($vresult["CAMPOS"] as $kCampos => $vCampos) {
          if ($vCampos) {
            $objPHPExcel->setActiveSheetIndex($x_sheet)->setCellValue($GLOBALS["column_alpha"][$x_colum] . $x_in, $vDados[$kCampos]);
            $x_colum++;
          }
        }
      }
      $x_sheet++;
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
  }
}
