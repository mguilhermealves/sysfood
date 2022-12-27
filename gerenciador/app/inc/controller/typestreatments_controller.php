<?php
class typestreatments_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    $typestreatments = new typestreatments_model();
    $typestreatments->set_field(array($key, $field));
    $typestreatments->set_filter($filters);
    $typestreatments->load_data();
    $out = array();
    foreach ($typestreatments->data as $value) {
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

    $typestreatments = new typestreatments_model();

    $typestreatments->set_field(array("idx", " name "));

    if ($info["format"] != ".json") {
      $typestreatments->set_paginate(array($info["sr"], $paginate));
    } else {
      $typestreatments->set_paginate(array(0, 900000));
    }

    $typestreatments->set_filter($filter);

    $typestreatments->load_data();
    $data = $typestreatments->data;
    $total = $typestreatments->con->result($typestreatments->con->select(" ifnull( count( idx ) , 0 ) as s ", " typestreatments ", " where " . implode(" and ", $filter)), "s", 0);
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
        $page = 'Tipos';
        $form = array(
          "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["typestreatments_url"], $done) : $GLOBALS["typestreatments_url"]), "pattern" => array(
            "new" => $GLOBALS["newtypetreatments_url"], "action" => $GLOBALS["typetreatment_url"], "search" => !empty($info["get"]) ? set_url($GLOBALS["typestreatments_url"], $info["get"]) : $GLOBALS["typestreatments_url"]
          )
        );
        include(constant("cRootServer") . "ui/common/header.inc.php");
        include(constant("cRootServer") . "ui/common/head.inc.php");
        include(constant("cRootServer") . "ui/page/treatments/types/treatments.php");
        include(constant("cRootServer") . "ui/common/footer.inc.php");
        include(constant("cRootServer") . "ui/common/list_actions.php");
        print('<script>' . "\n");
        print('    data_typestreatments_json = {' . "\n");
        print('        url: "' . $GLOBALS["typestreatments_url"] . '.json"' . "\n");
        print('        , data: ' . json_encode($done) . "\n");
        print('        , template: ""' . "\n");
        print('        , page: 1' . "\n");
        print('    }' . "\n");
        include(constant("cRootServer") . "furniture/js/add/typestreatments.js");
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
      $typestreatments = new typestreatments_model();
      $typestreatments->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $typestreatments->load_data();
      $data = current($typestreatments->data);

      $form = array(
        "url" => sprintf($GLOBALS["typetreatment_url"], $info["idx"])
      );
    } else {
      $data = array();
      $form = array(
        "url" => $GLOBALS["newtypetreatments_url"]
      );
    }

    $page = 'Tipos';
    include(constant("cRootServer") . "ui/common/header.inc.php");
    include(constant("cRootServer") . "ui/common/head.inc.php");
    include(constant("cRootServer") . "ui/page/treatments/types/treatment.php");
    include(constant("cRootServer") . "ui/common/footer.inc.php");
    print("<script>");
    print('$("button[name=\'btn_back\']").bind("click", function(){');
    print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["typestreatments_url"]) . '" ');
    print('})' . "\n");
    print('</script>' . "\n");
    include(constant("cRootServer") . "ui/common/foot.inc.php");
  }

  public function save($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }

    $typestreatments = new typestreatments_model();

    if (isset($info["idx"]) && (int)$info["idx"] > 0) {
      $typestreatments->set_filter(array(" idx = '" . $info["idx"] . "' "));
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

    $typestreatments->populate($info["post"]);
    $typestreatments->save();

    if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
      $info["idx"] = $typestreatments->con->insert_id;
    }

    if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
      basic_redir($info["post"]["done"]);
    } else {
      basic_redir($GLOBALS["typestreatments_url"]);
    }
  }

  public function remove($info)
  {
    if (!site_controller::check_login()) {
      basic_redir($GLOBALS["home_url"]);
    }
    if (isset($info["idx"])) {
      $typestreatments = new typestreatments_model();
      $typestreatments->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $typestreatments->remove();
    }
    if (isset($info["post"]["no-redirect"])) {
      print("ok");
    } else {
      if (isset($info["post"]["done"])) {
        basic_redir($info["post"]["done"]);
      } else {
        basic_redir($GLOBALS["typestreatments_url"]);
      }
    }
  }
}
