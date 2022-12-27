<?php
class news_controller{
	public static function data4select( $key = "idx" , $filters = array() , $field = "name" ){
		$news = new news_model();
		$news->set_field( array( $key , $field  ) ) ;
		$news->set_filter( $filters ) ;
        $news->load_data();
        $out = array();
		foreach( $news->data as $value ){
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
		if (isset($info["get"]["filter_profile"]) && !empty($info["get"]["filter_profile"])) {
			$done["filter_profile"] = $info["get"]["filter_profile"];
			$filter["filter_profile"] = " idx in ( select news_profiles.news_id from news_profiles where news_profiles.active = 'yes' and news_profiles.profiles_id = '" . $info["get"]["filter_profile"] . "' ) ";
		}
    return array( $done , $filter ) ;
  }

	public function display( $info ){
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }

    $paginate = 10 ;

    list( $done , $filter ) = $this->filter( $info );

    $news = new news_model();

    $news->set_field( array( "idx", " name "  ) ) ;

    if( $info["format"] != ".json" ){
      $news->set_paginate( array( $info["sr"] , $paginate ) ) ;
    } else{
      $news->set_paginate( array( 0 , 900000 ) ) ;
    }

    $news->set_filter( $filter ) ;

    $news->load_data();
    $news->attach( array("profiles") );
    $data = $news->data;
    $total = $news->con->result( $news->con->select(" ifnull( count( idx ) , 0 ) as s " , " news " , " where " . implode(" and " , $filter ) ) , "s" , 0 ) ;		    
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
        $page = 'news';
        $form = array(
          "done" => rawurlencode( !empty( $done ) ? set_url( $GLOBALS["news_url"] , $done ) : $GLOBALS["news_url"] ) 
          , "pattern" => array(
            "new" => $GLOBALS["newnews_url"]
            , "action" => $GLOBALS["new_url"]
            , "search" => !empty( $info["get"] ) ? set_url( $GLOBALS["news_url"], $info["get"] ) : $GLOBALS["news_url"] 
          )
        ) ;
        include( constant("cRootServer") . "ui/common/header.inc.php");
        include( constant("cRootServer") . "ui/common/head.inc.php");
        include( constant("cRootServer") . "ui/page/news.php");
        include( constant("cRootServer") . "ui/common/footer.inc.php");
        include( constant("cRootServer") . "ui/common/list_actions.php");
        print('<script>'."\n");
        print('    data_news_json = {'."\n");
        print('        url: "' . $GLOBALS["news_url"] . '.json"'."\n");
        print('        , data: ' . json_encode( $done ) . "\n");
        print('        , template: ""'."\n");
        print('        , page: 1'."\n");
        print('    }'."\n");
        include( constant("cRootServer") . "furniture/js/add/news.js");
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
      $news = new news_model();
      $news->set_filter( array( " idx = '" . $info["idx"] . "' " ) ) ;
      $news->load_data();
      $news->attach( array("profiles") );
      $data = current( $news->data );

      $form = array(
        "url" => sprintf( $GLOBALS["new_url"] , $info["idx"] )
      );
    } else{
      $data = array();
      $form = array(
        "url" => $GLOBALS["newnews_url"]
      );
    }
       
    $page = 'new';
    include( constant("cRootServer") . "ui/common/header.inc.php");
    include( constant("cRootServer") . "ui/common/head.inc.php");
    include( constant("cRootServer") . "ui/page/new.php");
    include( constant("cRootServer") . "ui/common/footer.inc.php");
    print("<script>");
    print('$("button[name=\'btn_back\']").bind("click", function(){');
    print(' document.location = "' . ( isset( $info["get"]["done"] ) ? $info["get"]["done"] : $GLOBALS["news_url"] ) . '" ');
    print('})'."\n");
    print('</script>'."\n");
    include( constant("cRootServer") . "ui/common/foot.inc.php");
  }

  public function save( $info ){
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }
    $news = new news_model();

    if( isset( $info["idx"] ) && (int)$info["idx"] > 0 ){
        $news->set_filter( array( " idx = '" . $info["idx"] . "' " ) ) ;
    } else{
        $info["post"]["slug"] = generate_slug( $info["post"]["name"] );
    }

    if( isset( $_FILES[ "image_file" ] ) && is_file( $_FILES[ "image_file" ]["tmp_name"] ) ){
      $d = preg_split("/\./", $_FILES[ "image_file" ]["name"] ) ;
      $extension = $d[ count( $d ) - 1 ];
      $name = generate_slug( preg_replace("/\." . $extension . "$/","", $_FILES[ "image_file" ]["name"]  ) )  ;
      $extension = date("YmdHis") . "." . $extension;
      $file = "furniture/upload/noticias/" . $name . $extension ;

      if (!file_exists(dirname(constant("cRootServer") . $file))) {
				mkdir(dirname(constant("cRootServer") . $file), 0777, true);
				chmod(dirname(constant("cRootServer") . $file), 0775);
			}

      if (file_exists(constant("cRootServer") . $file)) {
				unlink(constant("cRootServer") . $file);
			}

      move_uploaded_file( $_FILES[ "image_file" ]["tmp_name"] , constant("cRootServer") . $file );
      $info["post"]["image"] = $file ;
    }

    $news->populate( $info["post"] );
    $news->save();

    if( !isset( $info["idx"] ) || (int)$info["idx"] == 0 ){
      $info["idx"] = $news->con->insert_id;
    }

    $news->save_attach($info, array("profiles") );

    if( isset( $info["post"]["done"] ) && !empty( $info["post"]["done"] ) ){
      basic_redir( $info["post"]["done"] ) ;
    } else{
      basic_redir( $GLOBALS["news_url"] ) ;
    }
  }

  public function remove( $info ){

    
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }
    if( isset( $info["idx"] ) ){
      $news = new news_model();
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
        basic_redir( $GLOBALS["news_url"] ) ;
      }
    }
  }
}
