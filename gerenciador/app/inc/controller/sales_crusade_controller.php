<?php
class sales_crusade_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    $news = new combosales_model();
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

    $news = new combosales_model();

    $news->set_field(array("idx", " name "));

    if ($info["format"] != ".json") {
      $news->set_paginate(array($info["sr"], $paginate));
    } else {
      $news->set_paginate(array(0, 900000));
    }

    $news->set_filter($filter);

    $news->load_data();
    // $news->attach(array("profiles"));
    $data = $news->data;

    $total = $news->con->result($news->con->select(" ifnull( count( idx ) , 0 ) as s ", " productsbase ", " where " . implode(" and ", $filter)), "s", 0);
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
        $page = 'news';
        $form = array(
          "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["sales_crusade_url"], $done) : $GLOBALS["sales_crusade_url"]),
          "pattern" => array(
            "new" => $GLOBALS["newsale_crusade_url"],
            "action" => $GLOBALS["sale_crusade_url"],
            "search" => !empty($info["get"]) ? set_url($GLOBALS["sales_crusade_url"], $info["get"]) : $GLOBALS["sales_crusade_url"]
          )
        );
        include(constant("cRootServer") . "ui/common/header.inc.php");
        include(constant("cRootServer") . "ui/common/head.inc.php");
        include(constant("cRootServer") . "ui/page/products/sales/sales.php");
        include(constant("cRootServer") . "ui/common/footer.inc.php");
        include(constant("cRootServer") . "ui/common/list_actions.php");
        print('<script>' . "\n");
        print('    data_products_base_json = {' . "\n");
        print('        url: "' . $GLOBALS["sales_crusade_url"] . '.json"' . "\n");
        print('        , data: ' . json_encode($done) . "\n");
        print('        , template: ""' . "\n");
        print('        , page: 1' . "\n");
        print('    }' . "\n");
        include(constant("cRootServer") . "furniture/js/add/products/sales/sales.js");
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

    $goalstypes_lists = goalstypes_controller::data4select("slug", array(" idx > 0 "), "slug");

    if (isset($info["idx"])) {
      $product = new combosales_model();
      $product->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $product->load_data();
      $product->attach(array("combosalesgoals"));
      $data = current($product->data);

      $form = array(
        "url" => sprintf($GLOBALS["sale_crusade_url"], $info["idx"])
      );
    } else {
      $data = array();
      $form = array(
        "url" => $GLOBALS["newsale_crusade_url"]
      );
    }

    $page = 'product_base';

    include(constant("cRootServer") . "ui/common/header.inc.php");
    include(constant("cRootServer") . "ui/common/head.inc.php");
    include(constant("cRootServer") . "ui/page/products/sales/sale.php");
    include(constant("cRootServer") . "ui/common/footer.inc.php");

    print("<script>");
    print('$("button[name=\'btn_back\']").bind("click", function(){');
    print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["sales_crusade_url"]) . '" ');
    print('})' . "\n");

    include(constant("cRootServer") . "furniture/js/add/products/sales/sale.js");

    if (isset($data["combosalesgoals_attach"][0])) {
      foreach ($data["combosalesgoals_attach"] as $v) {
        print("\n" . 'kpi_salecruzade.add_table({ ' . "\n");
        print('	idx:  "' . $v["idx"] . '"' . "\n");
        print('	, id_key:  "' . $v["idx"] . '"' . "\n");
        print('	, idx_goalstype:  "' . $v["idx"] . '"' . "\n");
        print('	, name_goaltype:  "' . $v["name"] . '"' . "\n");
        print('	, point:  "' . $v["point"]. '"' . "\n");
        print('})' . "\n");
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
    $combosale = new combosales_model();

    if (isset($info["idx"]) && (int)$info["idx"] > 0) {
      $combosale->set_filter(array(" idx = '" . $info["idx"] . "' "));
    } else {
      $info["post"]["slug"] = generate_slug($info["post"]["name"]);
    }

    $combosale->populate($info["post"]);
    $combosale->save();

    if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
      $info["idx"] = $combosale->con->insert_id;
    }

    if (isset($info["post"]["kpi_salecruzade"])) {

      foreach ($info["post"]["kpi_salecruzade"] as $k => $v) {

        if (isset($info["post"]["kpi_salecruzade"][$k]["idx"])) {
          $info["post"]["combosalesgoals_id"][] = $info["post"]["kpi_salecruzade"][$k]["idx"];
        } else {
          $combosalesgoals = new combosalesgoals_model();

          $combosalesgoals->populate($info["post"]["kpi_salecruzade"][$k]["post"]);
          $combosalesgoals->save();

          $created_at = date("Y-m-d H:i:s");

          $info["post"]["combosalesgoals_id"][] = $combosalesgoals->con->insert_id;
          $combosalesgoals->set_filter(array(" idx = '" . $combosalesgoals->con->insert_id . "'"));
          $combosalesgoals->populate(array("created_at" => $created_at));
          $combosalesgoals->save();
        }
      }
    }

    $combosale->save_attach($info, array("combosalesgoals"));

    if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
      basic_redir($info["post"]["done"]);
    } else {
      basic_redir($GLOBALS["sales_crusade_url"]);
    }
  }

  public function remove($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    if (isset($info["idx"])) {
      $combosale = new combosales_model();
      $combosale->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $combosale->remove();
    }

    if (isset($info["post"]["no-redirect"])) {
      print("ok");
    } else {
      if (isset($info["post"]["done"])) {
        basic_redir($info["post"]["done"]);
      } else {
        basic_redir($GLOBALS["sales_crusade_url"]);
      }
    }
  }
}
