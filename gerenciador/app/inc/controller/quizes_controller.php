<?php
class quizes_controller
{
  public static function data4select($key = "idx", $filters = array( " active = 'yes' "), $field = "name")
  {
    $quizes = new quizes_model();
    $quizes->set_field(array($key, $field));
    $quizes->set_filter($filters);
    $quizes->load_data();
    $out = array();
    foreach ($quizes->data as $value) {
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
			$filter["filter_profile"] = " idx in ( select quizes_profiles.quizes_id from quizes_profiles where quizes_profiles.active = 'yes' and quizes_profiles.profiles_id = '" . $info["get"]["filter_profile"] . "' ) ";
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
    $quizes = new quizes_model();
    $quizes->set_field(array("idx", " name ", " level ", " published_at "));
    if ($info["format"] != ".json") {
      $quizes->set_paginate(array($info["sr"], $paginate));
    } else {
      $quizes->set_paginate(array(0, 900000));
    }
    $quizes->set_filter($filter);

    $quizes->load_data();
    $quizes->attach( array("profiles") );
    $data = $quizes->data;
    $total = $quizes->con->result($quizes->con->select(" ifnull( count( idx ) , 0 ) as s ", " quizes ", " where " . implode(" and ", $filter)), "s", 0);

    switch ($info["format"]) {
      case ".json":
        header('Content-type: application/json');
        echo json_encode(
          array(
            "total" =>  array("total" => $total), "row" => $data
          )
        );
        break;
      default:
        $page = 'quizes';
        $form = array(
          "done" => rawurlencode(!empty($done) ? set_url($GLOBALS["quizes_url"], $done) : $GLOBALS["quizes_url"]), "pattern" => array(
            "new" => $GLOBALS["newquiz_url"], "action" => $GLOBALS["quiz_url"], "search" => !empty($info["get"]) ? set_url($GLOBALS["quizes_url"], $info["get"]) : $GLOBALS["quizes_url"]
          )
        );
        include(constant("cRootServer") . "ui/common/header.inc.php");
        include(constant("cRootServer") . "ui/common/head.inc.php");
        include(constant("cRootServer") . "ui/page/quizes.php");
        include(constant("cRootServer") . "ui/common/footer.inc.php");
        include( constant("cRootServer") . "ui/common/list_actions.php");
        print('<script>' . "\n");
        print('    data_quizes_json = {' . "\n");
        print('        url: "' . $GLOBALS["quizes_url"] . '.json"' . "\n");
        print('        , data: ' . json_encode($done) . "\n");
        print('        , template: ""' . "\n");
        print('        , page: 1' . "\n");
        print('    }' . "\n");
        include(constant("cRootServer") . "furniture/js/add/quizes.js");
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
      $quizes = new quizes_model();
      $quizes->set_filter(array(" idx = '" . $info["idx"] . "' "));
      $quizes->load_data();
      $quizes->attach( array("profiles") );
      $data = current($quizes->data);
      $data["questions"] = unserialize($data["questions"]);
      $form = array(
        "url" => sprintf($GLOBALS["quiz_url"], $info["idx"])
      );
    } else {
      $data = array();
      $form = array(
        "url" => $GLOBALS["newquiz_url"]
      );
    }
    $page = 'quiz';
    include(constant("cRootServer") . "ui/common/header.inc.php");
    include(constant("cRootServer") . "ui/common/head.inc.php");
    include(constant("cRootServer") . "ui/page/quiz.php");
    include(constant("cRootServer") . "ui/common/footer.inc.php");
    print("<script>");
    print('$("button[name=\'btn_back\']").bind("click", function(){');
    print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : $GLOBALS["quizes_url"]) . '" ');
    print('})' . "\n");
    include(constant("cRootServer") . "furniture/js/add/quiz.js");

    if (isset($data["questions"]["data"])) {
      $i = 1;
      foreach ($data["questions"]["data"] as $k => $v) {
        print("quiz.add_question({\n");
        print("    id_key : '" . $k . "'\n");
        print("    , num: '" . $i . "'\n");
        print("    , CORRECT: '" . $v["correct"] . "'\n");
        print("    , pergunta: '" . $v["pergunta"] . "'\n");
        print("    , target: $(\"#accordionFlushExample\")\n");
        print("});\n");
        foreach ($v["resposta"] as $r => $s) {
          print("quiz.add_resposta({\n");
          print("    id_key : '" . $k . "'\n");
          print("    , id : '" . $r . "'\n");
          print("    , checked: '" . ($v["correct"] == $r ? " x " : "") . "'\n");
          print("    , text: '" . $s["text"] . "'\n");
          print("    , correct: '" . ($v["correct"] == $r ? "yes" : "no") . "'\n");
          print("});\n");
        }
        $i++;
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
    $quizes = new quizes_model();
    if (isset($info["idx"]) && (int)$info["idx"] > 0) {
      $quizes->set_filter(array(" idx = '" . $info["idx"] . "' "));
    } else {
      $info["post"]["slug"] = generate_slug($info["post"]["name"]);
    }

    $info["post"]["questions"] = serialize($info["post"]["questions"]);

    if (isset($_FILES["catalogo_file"]) && is_file($_FILES["catalogo_file"]["tmp_name"])) {
      $d = preg_split("/\./", $_FILES["catalogo_file"]["name"]);
      $extension = $d[count($d) - 1];
      $name = generate_slug(preg_replace("/\." . $extension . "$/", "", $_FILES["catalogo_file"]["name"]));
      $extension = date("YmdHis") . "." . $extension;
      $file = "furniture/upload/quiz/" . $name . $extension;
      if (file_exists(constant("cRootServer") . $file)) {
        unlink(constant("cRootServer") . $file);
      }
      move_uploaded_file($_FILES["catalogo_file"]["tmp_name"], constant("cRootServer") . $file);
      $info["post"]["catalogo"] = $file;
    }

    $quizes->populate($info["post"]);
    $quizes->save();
    if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
      $info["idx"] = $quizes->con->insert_id;
    }

    $quizes->save_attach($info, array("profiles") );

    if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
      basic_redir($info["post"]["done"]);
    } else {
      basic_redir($GLOBALS["quizes_url"]);
    }
  }

  public function remove( $info ){    
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }
    if( isset( $info["idx"] ) ){
      $news = new quizes_model();
      $news->set_filter( array( " idx = '" . $info["idx"] . "' " ) ) ;
      $news->remove();			
    }	
    if( isset( $info["post"]["no-redirect"] ) ){
      print("ok");
    }
    else{
      if( isset( $info["post"]["done"] ) ){
        basic_redir( $info["post"]["done"] ) ;
      }
      else{
        basic_redir( $GLOBALS["quizes_url"] ) ;
      }
    }
  }
}
