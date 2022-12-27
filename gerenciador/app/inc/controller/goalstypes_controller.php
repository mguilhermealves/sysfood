<?php
class goalstypes_controller{
	public static function data4select( $key = "idx" , $filters = array() , $field = "name" ){
		$goals = new goalstypes_model();
		$goals->set_field( array( $key , $field  ) ) ;
		$goals->set_filter( $filters ) ;
        $goals->load_data();
        $out = array();
		foreach( $goals->data as $value ){
			$out[ $value[ $key ] ] = $value[ $field ] ;
		}
		return $out ;
	}

  private function filter( $info ){
    $done = array();
    $filter = array( " active = 'yes' " );
    if( isset( $info["get"]["filter_name"] ) && !empty( $info["get"]["filter_name"] ) ){
      $done["filter_name"] = $info["get"]["filter_name"] ;
      $filter["filter_name"] = " name like '%" . $info["get"]["filter_name"] . "%' " ;
    }
    return array( $done , $filter ) ;
  }

	public function display( $info ){
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }

    $paginate = 10 ;

    list( $done , $filter ) = $this->filter( $info );

    $goals = new goalstypes_model();

    $goals->set_field( array( "idx", " name ", " slug " , " context "  ) ) ;

    if( $info["format"] != ".json" ){
      $goals->set_paginate( array( $info["sr"] , $paginate ) ) ;
    } else{
      $goals->set_paginate( array( 0 , 900000 ) ) ;
    }

    $goals->set_filter( $filter ) ;

    $goals->load_data();
    $goals->attach( array("profiles") );
    $data = $goals->data;
    $total = $goals->con->result( $goals->con->select(" ifnull( count( idx ) , 0 ) as s " , " goalstypes " , " where " . implode(" and " , $filter ) ) , "s" , 0 ) ;		    
    switch( $info["format"] ){
      case ".json":
        header('Content-type: application/json');
        echo json_encode( 
            array( 
                "total" => array( "total" => $total )
                , "row" => $data 
            ) 
        );
      break;
      default:
        $page = 'goals';
        $form = array(
          "done" => rawurlencode( !empty( $done ) ? set_url( $GLOBALS["goals_url"] , $done ) : $GLOBALS["goals_url"] ) 
          , "pattern" => array(
            "goal" => $GLOBALS["newgoals_url"]
            , "action" => $GLOBALS["goal_url"]
            , "search" => !empty( $info["get"] ) ? set_url( $GLOBALS["goals_url"], $info["get"] ) : $GLOBALS["goals_url"] 
          )
        ) ;
        include( constant("cRootServer") . "ui/common/header.inc.php");
        include( constant("cRootServer") . "ui/common/head.inc.php");
        include( constant("cRootServer") . "ui/page/goals.php");
        include( constant("cRootServer") . "ui/common/footer.inc.php");
        print('<script>'."\n");
        print('    data_goals_json = {'."\n");
        print('        url: "' . $GLOBALS["goals_url"] . '.json"'."\n");
        print('        , data: ' . json_encode( $done ) . "\n");
        print('        , template: ""'."\n");
        print('        , page: 1'."\n");
        print('    }'."\n");
        include( constant("cRootServer") . "furniture/js/add/goals.js");
        print('</script>'."\n");
        include( constant("cRootServer") . "ui/common/foot.inc.php");
      break;
    }
	}

	public function form( $info ){
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }

    $profiles_lists = profiles_controller::data4select("idx", array(" editabled != 'no' "), "name");

    if( isset( $info["idx"] ) ){
      $goals = new goalstypes_model();
      $goals->set_filter( array( " idx = '" . $info["idx"] . "' " ) ) ;
      $goals->load_data();
      $goals->attach( array("profiles") );
      $data = current( $goals->data );

      $form = array(
        "url" => sprintf( $GLOBALS["goal_url"] , $info["idx"] )
      );
    } else{
      $data = array();
      $form = array(
        "url" => $GLOBALS["newgoals_url"]
      );
    }
       
    $page = 'goal';
    include( constant("cRootServer") . "ui/common/header.inc.php");
    include( constant("cRootServer") . "ui/common/head.inc.php");
    include( constant("cRootServer") . "ui/page/goal.php");
    include( constant("cRootServer") . "ui/common/footer.inc.php");
    print("<script>");
    print('$("button[name=\'btn_back\']").bind("click", function(){');
    print(' document.location = "' . ( isset( $info["get"]["done"] ) ? $info["get"]["done"] : $GLOBALS["goals_url"] ) . '" ');
    print('})'."\n");
    print('</script>'."\n");
    include( constant("cRootServer") . "ui/common/foot.inc.php");
  }

  public function save( $info ){
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }
    
    $goals = new goalstypes_model();

    if( isset( $info["idx"] ) && (int)$info["idx"] > 0 ){
        $goals->set_filter( array( " idx = '" . $info["idx"] . "' " ) ) ;
    } else{
        $info["post"]["slug"] = generate_slug( $info["post"]["name"] );
    }

    $goals->populate( $info["post"] );
    $goals->save();

    if( !isset( $info["idx"] ) || (int)$info["idx"] == 0 ){
      $info["idx"] = $goals->con->insert_id;
    }

    $goals->save_attach($info, array("profiles") );

    if( isset( $info["post"]["done"] ) && !empty( $info["post"]["done"] ) ){
      basic_redir( $info["post"]["done"] ) ;
    } else{
      basic_redir( $GLOBALS["goals_url"] ) ;
    }
  }
}
