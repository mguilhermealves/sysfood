<?php
class urls_controller{
	public static function data4select( $key = "idx" , $filters = array() , $field = "name" ){
		$boiler = new urls_model();
		$boiler->set_field( array( $key , $field  ) ) ;
    $boiler->set_filter( $filters ) ;
    $boiler->set_order( array( $field . " asc " ) );
    $boiler->load_data();
    $out = array();
		foreach( $boiler->data as $value ){
			$out[ $value[ $key ] ] = $value[ $field ] ;
		}
		return $out ;
	}
  private function filter( $info ){
    $done = array();
    $filter = array( " idx > 0 ",  "active = 'yes'" );
    if( isset( $info["get"]["filter_name"] ) && !empty( $info["get"]["filter_name"] ) ){
      $done["filter_name"] = $info["get"]["filter_name"] ;
      $filter["filter_name"] = " name like '%" . $info["get"]["filter_name"] . "%' " ;
    }
    if( isset( $info["get"]["filter_slug"] ) && !empty( $info["get"]["filter_slug"] ) ){
      $done["filter_slug"] = $info["get"]["filter_slug"] ;
      $filter["filter_slug"] = " slug like '%" . $info["get"]["filter_slug"] . "%' " ;
    }
    if( isset( $info["get"]["filter_pattern"] ) && !empty( $info["get"]["filter_pattern"] ) ){
      $done["filter_pattern"] = $info["get"]["filter_pattern"] ;
      $filter["filter_pattern"] = " pattern like '%" . $info["get"]["filter_pattern"] . "%' " ;
    }
    return array( $done , $filter ) ;
  }
	public function display( $info ){
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }
    $paginate = isset( $info["get"]["paginate"] ) && (int)$info["get"]["paginate"] > 20 ? $info["get"]["paginate"] : 20 ;

    list( $done , $filter ) = $this->filter( $info );
    $boiler = new urls_model();
    $boiler->set_filter( $filter ) ;
    $boiler->set_paginate( array( $info["sr"] , $paginate ) ) ;
    $boiler->set_order( array( " name asc " ) ) ;
    list( $recordset , $data ) = $boiler->return_data();
    $page = "Urls";
    $form = array(
        "title" => "Listagem de Urls"
        , "titlenew" => "Nova Url"
        , "new" => $GLOBALS["newurl_url"]
        , "search" => $GLOBALS["urls_url"]
        , "action" => set_url( $GLOBALS["url_url"] , $done )
    ) ;
    include( constant("cRootServer") . "ui/common/header.inc.php");
    include( constant("cRootServer") . "ui/common/head.inc.php");
    include( constant("cRootServer") . "ui/page/urls.php");
    include( constant("cRootServer") . "ui/common/footer.inc.php");
    include( constant("cRootServer") . "ui/common/list_actions.php");
    include( constant("cRootServer") . "ui/common/foot.inc.php");
	}
	public function form( $info ){
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }
    $page = "Urls";
    $data = array();
    $form = array(
      "title" => "Cadastrar Url"
      , "url" => $GLOBALS["newurl_url"] 
    );
    $info["get"]["done"] =  set_url( $GLOBALS["urls_url"] , $info["get"] );
    if( isset( $info["idx"] ) && (int)$info["idx"] > 0 ){
        $boiler = new urls_model();
        $boiler->set_filter( array( " idx = '" . $info["idx"] . "'" ) ) ;
        $boiler->load_data();
        $boiler->set_paginate( array(1) ) ;
        $data = current( $boiler->data ) ;
        $form["title"] = "Editar Url";
        $form["url"] = sprintf( $GLOBALS["url_url"] , $info["idx"] ) ;
    }
    include( constant("cRootServer") . "ui/common/header.inc.php");
    include( constant("cRootServer") . "ui/common/head.inc.php");
    include( constant("cRootServer") . "ui/page/url.php");
    include( constant("cRootServer") . "ui/common/footer.inc.php");
    include( constant("cRootServer") . "ui/common/foot.inc.php");
	}
  public function save( $info ){
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }
    $boiler = new urls_model();
    if( isset( $info["idx"] ) ){
      $boiler->set_filter( array( " idx = '" . $info["idx"] . "' " ) ) ;
    }
    $boiler->populate( $info["post"] );
    $boiler->save();
    if( isset( $info["post"]["no-redirect"] ) ){
      print("ok");
    }
    else{
      if( isset( $info["post"]["done"] ) ){
        basic_redir( $info["post"]["done"] ) ;
      }
      else{
        basic_redir( $GLOBALS["urls_url"] ) ;
      }
    }
  }
  public function remove( $info ){
    if( ! site_controller::check_login() ){
      basic_redir( $GLOBALS["home_url"] ) ;
    }
    if( isset( $info["idx"] ) ){
      $boiler = new urls_model();
      $boiler->set_filter( array( " idx = '" . $info["idx"] . "' " ) ) ;
      $boiler->remove();			
    }	
    if( isset( $info["post"]["no-redirect"] ) ){
      print("ok");
    }
    else{
      if( isset( $info["post"]["done"] ) ){
        basic_redir( $info["post"]["done"] ) ;
      }
      else{
        basic_redir( $GLOBALS["urls_url"] ) ;
      }
    }
  }
}
