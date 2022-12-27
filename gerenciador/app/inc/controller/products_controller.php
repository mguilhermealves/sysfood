<?php
class products_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    $news = new products_model();
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

    $products = new products_model();

    $products->set_field(array("idx", " name ", "value"));

    if ($info["format"] != ".json") {
      $products->set_paginate(array($info["sr"], $paginate));
    } else {
      $products->set_paginate(array(0, 900000));
    }

    $products->set_filter($filter);

    $products->load_data();
    $products->attach(array("categories"), null, null, null);
    $data = $products->data;

    $total = $products->con->result($products->con->select(" ifnull( count( idx ) , 0 ) as s ", " products ", " where " . implode(" and ", $filter)), "s", 0);
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
        $page = 'products';
        $form = array(
          "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["products_url"], $done) : $GLOBALS["products_url"]),
          "pattern" => array(
            "new" => $GLOBALS["newproduct_url"],
            "action" => $GLOBALS["product_url"],
            "search" => !empty($info["get"]) ? set_url($GLOBALS["products_url"], $info["get"]) : $GLOBALS["products_url"]
          )
        );
        include(constant("cRootServer") . "ui/common/header.inc.php");
        include(constant("cRootServer") . "ui/common/head.inc.php");
        include(constant("cRootServer") . "ui/page/products/products/products.php");
        include(constant("cRootServer") . "ui/common/footer.inc.php");
        include(constant("cRootServer") . "ui/common/list_actions.php");
        print('<script>' . "\n");
        print('    data_products_json = {' . "\n");
        print('        url: "' . $GLOBALS["products_url"] . '.json"' . "\n");
        print('        , data: ' . json_encode($done) . "\n");
        print('        , template: ""' . "\n");
        print('        , page: 1' . "\n");
        print('    }' . "\n");
        include(constant("cRootServer") . "furniture/js/add/products.js");
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
      $product = new products_model();
      $product->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $product->load_data();
      $product->attach(array("categories"), null, null, null);
      $data = current($product->data);

      $form = array(
        "url" => sprintf($GLOBALS["product_url"], $info["idx"])
      );
    } else {
      $data = array();
      $form = array(
        "url" => $GLOBALS["newproduct_url"]
      );
    }

    // print_pre($data, true);

    $page = 'product';

    include(constant("cRootServer") . "ui/common/header.inc.php");
    include(constant("cRootServer") . "ui/common/head.inc.php");
    include(constant("cRootServer") . "ui/page/products/products/product.php");
    include(constant("cRootServer") . "ui/common/footer.inc.php");

    print("<script>");
    print('$("button[name=\'btn_back\']").bind("click", function(){');
    print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["products_url"]) . '" ');
    print('})' . "\n");

    include(constant("cRootServer") . "furniture/js/add/products/bases/base.js");
    include(constant("cRootServer") . "ui/common/foot.inc.php");
  }

  public function save($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }
    $product = new products_model();

    if (isset($info["idx"]) && (int)$info["idx"] > 0) {
      $product->set_filter(array(" idx = '" . $info["idx"] . "' "));
    }

    $product->populate($info["post"]);
    $product->save();

    if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
      $info["idx"] = $product->con->insert_id;
    }

    $product->save_attach($info, array("categories"));

    if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
      basic_redir($info["post"]["done"]);
    } else {
      basic_redir($GLOBALS["products_url"]);
    }
  }

  public function remove($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    if (isset($info["idx"])) {
      $product = new products_model();
      $product->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $product->remove();
    }
    
    if (isset($info["post"]["no-redirect"])) {
      print("ok");
    } else {
      if (isset($info["post"]["done"])) {
        basic_redir($info["post"]["done"]);
      } else {
        basic_redir($GLOBALS["products_url"]);
      }
    }
  }
}
