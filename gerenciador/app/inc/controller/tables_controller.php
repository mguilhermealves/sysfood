<?php
class tables_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    $news = new tables_model();
    $news->set_field(array($key, $field));
    $news->set_filter($filters);
    $news->load_data();
    $out = array();
    foreach ($news->data as $value) {
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
    if (isset($info["get"]["filter_profile"]) && !empty($info["get"]["filter_profile"])) {
      $done["filter_profile"] = $info["get"]["filter_profile"];
      $filter["filter_profile"] = " idx in ( select news_profiles.news_id from news_profiles where news_profiles.active = 'yes' and news_profiles.profiles_id = '" . $info["get"]["filter_profile"] . "' ) ";
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

    $tables = new tables_model();

    $tables->set_field(array("idx", " name ","qtd_chairs", "position"));

    if ($info["format"] != ".json") {
      $tables->set_paginate(array($info["sr"], $paginate));
    } else {
      $tables->set_paginate(array(0, 900000));
    }

    $tables->set_filter($filter);

    $tables->load_data();
    $data = $tables->data;

    $total = $tables->con->result($tables->con->select(" ifnull( count( idx ) , 0 ) as s ", " tables ", " where " . implode(" and ", $filter)), "s", 0);

    switch ($info["format"]) {
      case ".json":
        header('Content-type: application/json');
        echo json_encode(
          array(
            "total" => array("total" => $total), "row" => $data
          )
        );
        break;
      default:
        $page = 'Mesas';
        $form = array(
          "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["tables_url"], $done) : $GLOBALS["tables_url"]),
          "pattern" => array(
            "new" => $GLOBALS["newtable_url"],
            "action" => $GLOBALS["table_url"],
            "search" => !empty($info["get"]) ? set_url($GLOBALS["tables_url"], $info["get"]) : $GLOBALS["tables_url"]
          )
        );
        include(constant("cRootServer") . "ui/common/header.inc.php");
        include(constant("cRootServer") . "ui/common/head.inc.php");
        include(constant("cRootServer") . "ui/page/tables/tables.php");
        include(constant("cRootServer") . "ui/common/footer.inc.php");
        include(constant("cRootServer") . "ui/common/list_actions.php");
        print('<script>' . "\n");
        print('    data_tables_json = {' . "\n");
        print('        url: "' . $GLOBALS["tables_url"] . '.json"' . "\n");
        print('        , data: ' . json_encode($done) . "\n");
        print('        , template: ""' . "\n");
        print('        , page: 1' . "\n");
        print('    }' . "\n");
        include(constant("cRootServer") . "furniture/js/add/tables.js");
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
      $table = new tables_model();
      $table->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $table->load_data();
      $data = current($table->data);

      $form = array(
        "url" => sprintf($GLOBALS["table_url"], $info["idx"])
      );
    } else {
      $data = array();
      $form = array(
        "url" => $GLOBALS["newtable_url"]
      );
    }

    $page = 'Mesas';

    include(constant("cRootServer") . "ui/common/header.inc.php");
    include(constant("cRootServer") . "ui/common/head.inc.php");
    include(constant("cRootServer") . "ui/page/tables/table.php");
    include(constant("cRootServer") . "ui/common/footer.inc.php");

    print("<script>");
    print('$("button[name=\'btn_back\']").bind("click", function(){');
    print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["tables_url"]) . '" ');
    print('})' . "\n");

    include(constant("cRootServer") . "furniture/js/add/products/bases/base.js");
    include(constant("cRootServer") . "ui/common/foot.inc.php");
  }

  public function save($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    $table = new tables_model();

    if (isset($info["idx"]) && (int)$info["idx"] > 0) {
      $table->set_filter(array(" idx = '" . $info["idx"] . "' "));
    }

    $table->populate($info["post"]);
    $table->save();

    if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
      basic_redir($info["post"]["done"]);
    } else {
      basic_redir($GLOBALS["tables_url"]);
    }
  }

  public function remove($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    if (isset($info["idx"])) {
      $product = new tables_model();
      $product->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $product->remove();
    }
    
    if (isset($info["post"]["no-redirect"])) {
      print("ok");
    } else {
      if (isset($info["post"]["done"])) {
        basic_redir($info["post"]["done"]);
      } else {
        basic_redir($GLOBALS["tables_url"]);
      }
    }
  }
}
