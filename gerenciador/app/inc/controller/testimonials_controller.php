<?php
class testimonials_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    $testimonials = new testimonials_model();
    $testimonials->set_field(array($key, $field));
    $testimonials->set_filter($filters);
    $testimonials->load_data();
    $out = array();
    foreach ($testimonials->data as $value) {
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

    if (isset($info["get"]["filter_type"]) && !empty($info["get"]["filter_type"])) {
      $done["filter_type"] = $info["get"]["filter_type"];
      $filter["filter_type"] = " type in ( select typestreatments.idx from typestreatments where typestreatments.active = 'yes' and typestreatments.idx = '" . $info["get"]["filter_type"] . "' ) ";
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

    $testimonials = new testimonials_model();

    if ($info["format"] != ".json") {
      $testimonials->set_paginate(array($info["sr"], $paginate));
    } else {
      $testimonials->set_paginate(array(0, 900000));
    }

    $testimonials->set_filter($filter);
    $testimonials->load_data();
    $testimonials->join("units", 'units', array("idx" => "unit"), null, array("idx", "trade_name"));
    $data = $testimonials->data;

    $total = $testimonials->con->result($testimonials->con->select(" ifnull( count( idx ) , 0 ) as s ", " testimonials ", " where " . implode(" and ", $filter)), "s", 0);

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
        $page = 'Depoimentos';
        $form = array(
          "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["testimonials_url"], $done) : $GLOBALS["testimonials_url"]), "pattern" => array(
            "new" => $GLOBALS["newtestimonial_url"], "action" => $GLOBALS["testimonial_url"], "search" => !empty($info["get"]) ? set_url($GLOBALS["testimonials_url"], $info["get"]) : $GLOBALS["testimonials_url"]
          )
        );
        include(constant("cRootServer") . "ui/common/header.inc.php");
        include(constant("cRootServer") . "ui/common/head.inc.php");
        include(constant("cRootServer") . "ui/page/testimonials/testimonials.php");
        include(constant("cRootServer") . "ui/common/footer.inc.php");
        include(constant("cRootServer") . "ui/common/list_actions.php");
        print('<script>' . "\n");
        print('    data_testimonials_json = {' . "\n");
        print('        url: "' . $GLOBALS["testimonials_url"] . '.json"' . "\n");
        print('        , data: ' . json_encode($done) . "\n");
        print('        , template: ""' . "\n");
        print('        , page: 1' . "\n");
        print('    }' . "\n");
        include(constant("cRootServer") . "furniture/js/add/testimonials.js");
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
      $testimonial = new testimonials_model();
      $testimonial->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $testimonial->load_data();
      $testimonial->join("units", 'units', array("idx" => "unit"), null, array("idx", "trade_name"));
      $data = current($testimonial->data);

      $form = array(
        "url" => sprintf($GLOBALS["testimonial_url"], $info["idx"])
      );
    } else {
      $data = array();
      $form = array(
        "url" => $GLOBALS["newtestimonial_url"]
      );
    }

    $page = 'Depoimentos';
    include(constant("cRootServer") . "ui/common/header.inc.php");
    include(constant("cRootServer") . "ui/common/head.inc.php");
    include(constant("cRootServer") . "ui/page/testimonials/testimonial.php");
    include(constant("cRootServer") . "ui/common/footer.inc.php");
    print("<script>");
    print('$("button[name=\'btn_back\']").bind("click", function(){');
    print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["testimonials_url"]) . '" ');
    print('})' . "\n");
    print('</script>' . "\n");
    include(constant("cRootServer") . "ui/common/foot.inc.php");
  }

  public function save($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    $testimonials = new testimonials_model();

    if (isset($info["idx"]) && (int)$info["idx"] > 0) {
      $testimonials->set_filter(array(" idx = '" . $info["idx"] . "' "));
    }

    if (isset($_FILES["client_image"]) && is_file($_FILES["client_image"]["tmp_name"])) {
      $d = preg_split("/\./", $_FILES["client_image"]["name"]);
      $extension = $d[count($d) - 1];
      $name = generate_slug(preg_replace("/\." . $extension . "$/", "", $_FILES["client_image"]["name"]));
      $extension = date("YmdHis") . "." . $extension;
      $file = "furniture/upload/tipos-tratamentos/" . $name . $extension;

      if (!file_exists(dirname(constant("cRootServer") . $file))) {
        mkdir(dirname(constant("cRootServer") . $file), 0777, true);
        chmod(dirname(constant("cRootServer") . $file), 0775);
      }

      if (file_exists(constant("cRootServer") . $file)) {
        unlink(constant("cRootServer") . $file);
      }

      move_uploaded_file($_FILES["client_image"]["tmp_name"], constant("cRootServer") . $file);
      $info["post"]["client_image"] = $file;
    }

    $testimonials->populate($info["post"]);
    $testimonials->save();

    if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
      $info["idx"] = $testimonials->con->insert_id;
    }

    if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
      basic_redir($info["post"]["done"]);
    } else {
      basic_redir($GLOBALS["testimonials_url"]);
    }
  }

  public function remove($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }
    if (isset($info["idx"])) {
      $testimonials = new testimonials_model();
      $testimonials->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $testimonials->remove();
    }
    if (isset($info["post"]["no-redirect"])) {
      print("ok");
    } else {
      if (isset($info["post"]["done"])) {
        basic_redir($info["post"]["done"]);
      } else {
        basic_redir($GLOBALS["testimonials_url"]);
      }
    }
  }
}
