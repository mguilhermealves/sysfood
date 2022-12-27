<?php
class treatments_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    $treatments = new treatments_model();
    $treatments->set_field(array($key, $field));
    $treatments->set_filter($filters);
    $treatments->load_data();
    $out = array();
    foreach ($treatments->data as $value) {
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

    $treatments = new treatments_model();

    if ($info["format"] != ".json") {
      $treatments->set_paginate(array($info["sr"], $paginate));
    } else {
      $treatments->set_paginate(array(0, 900000));
    }

    $treatments->set_filter($filter);
    $treatments->load_data();
    $treatments->join("typestreatments", 'typestreatments', array("idx" => "type"), null, array("idx", "name"));
    $data = $treatments->data;

    $total = $treatments->con->result($treatments->con->select(" ifnull( count( idx ) , 0 ) as s ", " treatments ", " where " . implode(" and ", $filter)), "s", 0);

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
        $page = 'Tratamentos';
        $form = array(
          "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["treatments_url"], $done) : $GLOBALS["treatments_url"]), "pattern" => array(
            "new" => $GLOBALS["newtreatments_url"], "action" => $GLOBALS["treatment_url"], "search" => !empty($info["get"]) ? set_url($GLOBALS["treatments_url"], $info["get"]) : $GLOBALS["treatments_url"]
          )
        );
        include(constant("cRootServer") . "ui/common/header.inc.php");
        include(constant("cRootServer") . "ui/common/head.inc.php");
        include(constant("cRootServer") . "ui/page/treatments/treatments.php");
        include(constant("cRootServer") . "ui/common/footer.inc.php");
        include(constant("cRootServer") . "ui/common/list_actions.php");
        print('<script>' . "\n");
        print('    data_treatments_json = {' . "\n");
        print('        url: "' . $GLOBALS["treatments_url"] . '.json"' . "\n");
        print('        , data: ' . json_encode($done) . "\n");
        print('        , template: ""' . "\n");
        print('        , page: 1' . "\n");
        print('    }' . "\n");
        include(constant("cRootServer") . "furniture/js/add/treatments.js");
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
      $treatment = new treatments_model();
      $treatment->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $treatment->load_data();
      $treatment->join("typestreatments", 'typestreatments', array("idx" => "type"), null, array("idx", "name"));
      $data = current($treatment->data);

      $form = array(
        "url" => sprintf($GLOBALS["treatment_url"], $info["idx"])
      );
    } else {
      $data = array();
      $form = array(
        "url" => $GLOBALS["newtreatments_url"]
      );
    }

    $page = 'Tratamentos';
    include(constant("cRootServer") . "ui/common/header.inc.php");
    include(constant("cRootServer") . "ui/common/head.inc.php");
    include(constant("cRootServer") . "ui/page/treatments/treatment.php");
    include(constant("cRootServer") . "ui/common/footer.inc.php");
    print("<script>");
    print('$("button[name=\'btn_back\']").bind("click", function(){');
    print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["treatments_url"]) . '" ');
    print('})' . "\n");
    print('</script>' . "\n");
    include(constant("cRootServer") . "ui/common/foot.inc.php");
  }

  public function save($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    $treatments = new treatments_model();

    if (isset($info["idx"]) && (int)$info["idx"] > 0) {
      $treatments->set_filter(array(" idx = '" . $info["idx"] . "' "));
    }

    if (isset($_FILES["image_banner"]) && is_file($_FILES["image_banner"]["tmp_name"])) {
      $d = preg_split("/\./", $_FILES["image_banner"]["name"]);
      $extension = $d[count($d) - 1];
      $name = generate_slug(preg_replace("/\." . $extension . "$/", "", $_FILES["image_banner"]["name"]));
      $extension = date("YmdHis") . "." . $extension;
      $file = "furniture/upload/tipos-tratamentos/" . $name . $extension;

      if (!file_exists(dirname(constant("cRootServer") . $file))) {
        mkdir(dirname(constant("cRootServer") . $file), 0777, true);
        chmod(dirname(constant("cRootServer") . $file), 0775);
      }

      if (file_exists(constant("cRootServer") . $file)) {
        unlink(constant("cRootServer") . $file);
      }

      move_uploaded_file($_FILES["image_banner"]["tmp_name"], constant("cRootServer") . $file);
      $info["post"]["image_banner"] = $file;
    }

    $treatments->populate($info["post"]);
    $treatments->save();

    if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
      $info["idx"] = $treatments->con->insert_id;
    }

    if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
      basic_redir($info["post"]["done"]);
    } else {
      basic_redir($GLOBALS["treatments_url"]);
    }
  }

  public function remove($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }
    if (isset($info["idx"])) {
      $treatments = new treatments_model();
      $treatments->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $treatments->remove();
    }
    if (isset($info["post"]["no-redirect"])) {
      print("ok");
    } else {
      if (isset($info["post"]["done"])) {
        basic_redir($info["post"]["done"]);
      } else {
        basic_redir($GLOBALS["treatments_url"]);
      }
    }
  }
}
