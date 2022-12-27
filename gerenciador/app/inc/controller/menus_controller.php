<?php
class menus_controller{
	public static function data4select( $key = "idx" , $filters = array() , $field = "name" ){
		$boiler = new menus_model();
		$boiler->set_field( array( $key , $field  ) ) ;
        $boiler->set_filter( $filters ) ;
        $boiler->load_data();
        $boiler->set_order( array( $field . " asc " ) );
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
        if( isset( $info["get"]["filter_profile"] ) && !empty( $info["get"]["filter_profile"] ) ){
            $done["filter_profile"] = $info["get"]["filter_profile"] ;
            $filter["filter_profile"] = " idx in ( select menus_profiles.menus_id from menus_profiles where profiles_id = '" . $info["get"]["filter_profile"] . "' ) " ;
        }
        if( isset( $info["get"]["filter_parent"] ) && !empty( $info["get"]["filter_parent"] ) ){
            $done["filter_parent"] = $info["get"]["filter_parent"] ;
            $filter["filter_parent"] = " parent = '" . $info["get"]["filter_parent"] . "' " ;
        }
        return array( $done , $filter ) ;
    }
	public function display( $info ){
        if( ! site_controller::check_login() ){
        basic_redir( $GLOBALS["home_url"] ) ;
        }
        $paginate = isset( $info["get"]["paginate"] ) && (int)$info["get"]["paginate"] > 20 ? $info["get"]["paginate"] : 20 ;

        $page = "Menus";
        list( $done , $filter ) = $this->filter( $info );
        $boiler = new menus_model();
        $boiler->set_filter( $filter ) ;
        $boiler->set_paginate( array( $info["sr"] , $paginate ) ) ;
        list( $recordset , $data ) = $boiler->return_data();
        $boiler->attach( array("profiles") , false , " and idx > 1 " ) ;
        $boiler->attach( array("urls") , false ) ;
        $data = $boiler->data ;
        $menus_parents = menus_controller::data4select("idx", array(" idx > 0 ") );
        $menus_parents["-1"] = "--- Raiz ---";
        $form = array(
            "title" => "Listagem de Menus"
            , "titlenew" => "Nova Menu"
            , "new" => $GLOBALS["newmenu_url"]
            , "search" => $GLOBALS["menus_url"]
            , "action" => set_url( $GLOBALS["menu_url"] , $done )
        ) ;
        include( constant("cRootServer") . "ui/common/header.inc.php");
        include( constant("cRootServer") . "ui/common/head.inc.php");
        include( constant("cRootServer") . "ui/page/menus.php");
        include( constant("cRootServer") . "ui/common/footer.inc.php");
        include( constant("cRootServer") . "ui/common/list_actions.php");
        include( constant("cRootServer") . "ui/common/foot.inc.php");
	}
	public function form( $info ){
        if( ! site_controller::check_login() ){
            basic_redir( $GLOBALS["home_url"] ) ;
        }
        $page = "Menus";
        $data = array();
        $form = array(
            "title" => "Cadastrar Menu"
            , "url" => $GLOBALS["newmenu_url"] 
        );
        $info["get"]["done"] =  set_url( $GLOBALS["menus_url"] , $info["get"] );
        if( isset( $info["idx"] ) && (int)$info["idx"] > 0 ){
            $boiler = new menus_model();
            $boiler->set_filter( array( " idx = '" . $info["idx"] . "'" ) ) ;
            $boiler->load_data();
            $boiler->set_paginate( array(1) ) ;
            $boiler->attach( array("profiles") , false , " and idx > 1 " ) ;
            $boiler->attach( array("urls") ) ;
            $data = current( $boiler->data ) ;
            $form["title"] = "Editar Menu";
            $form["url"] = sprintf( $GLOBALS["menu_url"] , $info["idx"] ) ;
        }
        include( constant("cRootServer") . "ui/common/header.inc.php");
        include( constant("cRootServer") . "ui/common/head.inc.php");
        include( constant("cRootServer") . "ui/page/menu.php");
        include( constant("cRootServer") . "ui/common/footer.inc.php");
        include( constant("cRootServer") . "ui/common/foot.inc.php");
	}
    public function save( $info ){
        if( ! site_controller::check_login() ){
            basic_redir( $GLOBALS["home_url"] ) ;
        }
        $boiler = new menus_model();
        if( isset( $info["idx"] ) ){
            $boiler->set_filter( array( " idx = '" . $info["idx"] . "' " ) ) ;
        }
        $boiler->populate( $info["post"] );
        $boiler->save();

        if( !isset( $info["idx"] ) ){
            $info["idx"] = $boiler->con->insert_id;
        }
        $boiler->save_attach( $info , array( "profiles" , "urls" ) );

        if( isset( $info["post"]["no-redirect"] ) ){
            print("ok");
        }
        else{
            if( isset( $info["post"]["done"] ) ){
                basic_redir( $info["post"]["done"] ) ;
            }
            else{
                basic_redir( $GLOBALS["menus_url"] ) ;
            }
        }
    }
    public function remove( $info ){
        if( ! site_controller::check_login() ){
            basic_redir( $GLOBALS["home_url"] ) ;
        }
        if( isset( $info["idx"] ) ){
            $boiler = new menus_model();
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
                basic_redir( $GLOBALS["menus_url"] ) ;
            }
        }
    }
}
