<?php
class routes_controller{
	public static function data4select( $key = "idx" , $filters = array() , $field = "name" ){
		$boiler = new routes_model();
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
        if( isset( $info["get"]["filter_controller"] ) && !empty( $info["get"]["filter_controller"] ) ){
            $done["filter_controller"] = $info["get"]["filter_controller"] ;
            $filter["filter_controller"] = " controller like '%" . $info["get"]["filter_controller"] . "%' " ;
        }
        if( isset( $info["get"]["filter_pattern"] ) && !empty( $info["get"]["filter_pattern"] ) ){
            $done["filter_pattern"] = $info["get"]["filter_pattern"] ;
            $filter["filter_pattern"] = " pattern like '%" . $info["get"]["filter_pattern"] . "%' " ;
        }
        if( isset( $info["get"]["filter_profile"] ) && !empty( $info["get"]["filter_profile"] ) ){
            $done["filter_profile"] = $info["get"]["filter_profile"] ;
            $filter["filter_profile"] = " idx in ( select routes_profiles.routes_id from routes_profiles where routes_profiles.active = 'yes' and routes_profiles.profiles_id = '" . $info["get"]["filter_profile"] . "' ) " ;
        }
        return array( $done , $filter ) ;
    }
	public function display( $info ){
        if( ! site_controller::check_login() ){
            basic_redir( $GLOBALS["home_url"] ) ;
        }
        $paginate = isset( $info["get"]["paginate"] ) && (int)$info["get"]["paginate"] > 20 ? $info["get"]["paginate"] : 20 ;

        list( $done , $filter ) = $this->filter( $info );
        $boiler = new routes_model();
        $boiler->set_filter( $filter ) ;
        $boiler->set_paginate( array( $info["sr"] , $paginate ) ) ;
        $boiler->set_order( array( " name asc " ) ) ;
        list( $recordset , $data ) = $boiler->return_data();
        $boiler->attach( array("profiles") );
        $data = $boiler->data;
        $page = "Rotas";
        $form = array(
            "title" => "Listagem de Rotas"
            , "titlenew" => "Nova Rota"
            , "new" => $GLOBALS["newroute_url"]
            , "search" => $GLOBALS["routes_url"]
            , "action" => set_url( $GLOBALS["route_url"] , $done )
        ) ;
        include( constant("cRootServer") . "ui/common/header.inc.php");
        include( constant("cRootServer") . "ui/common/head.inc.php");
        include( constant("cRootServer") . "ui/page/routes.php");
        include( constant("cRootServer") . "ui/common/footer.inc.php");
        include( constant("cRootServer") . "ui/common/list_actions.php");
        include( constant("cRootServer") . "ui/common/foot.inc.php");
	}
	public function form( $info ){
        if( ! site_controller::check_login() ){
        basic_redir( $GLOBALS["home_url"] ) ;
        }
        $page = "Rotas";
        $data = array();
        $form = array(
        "title" => "Cadastrar Rota"
        , "url" => $GLOBALS["newroute_url"] 
        );
        $info["get"]["done"] =  set_url( $GLOBALS["routes_url"] , $info["get"] );
        if( isset( $info["idx"] ) && (int)$info["idx"] > 0 ){
            $boiler = new routes_model();
            $boiler->set_filter( array( " idx = '" . $info["idx"] . "'" ) ) ;
            $boiler->load_data();
            $boiler->attach( array("profiles") , false , " and idx > 1 " ) ;
            $boiler->set_paginate( array(1) ) ;
            $data = current( $boiler->data ) ;
            $form["title"] = "Editar Rota";
            $form["url"] = sprintf( $GLOBALS["route_url"] , $info["idx"] ) ;
        }
        include( constant("cRootServer") . "ui/common/header.inc.php");
        include( constant("cRootServer") . "ui/common/head.inc.php");
        include( constant("cRootServer") . "ui/page/route.php");
        include( constant("cRootServer") . "ui/common/footer.inc.php");
        include( constant("cRootServer") . "ui/common/foot.inc.php");
	}
    public function save( $info ){
        if( ! site_controller::check_login() ){
            basic_redir( $GLOBALS["home_url"] ) ;
        }
        $boiler = new routes_model();
        if( isset( $info["idx"] ) ){
            $boiler->set_filter( array( " idx = '" . $info["idx"] . "' " ) ) ;
        }
        $boiler->populate( $info["post"] );
        $boiler->save();
        if( !isset( $info["idx"] ) || (int)$info["idx"] == 0 ){
          $info["idx"] = $boiler->con->insert_id;
        }
        $boiler->save_attach( $info , array("profiles") );
        if( isset( $info["post"]["no-redirect"] ) ){
            print("ok");
        }
        else{
            if( isset( $info["post"]["done"] ) ){
                basic_redir( $info["post"]["done"] ) ;
            }
            else{
                basic_redir( $GLOBALS["routes_url"] ) ;
            }
        }
    }
    public function remove( $info ){

        print_pre( $GLOBALS["dispatcher"] );
        print_pre( $info );
        exit();
        if( ! site_controller::check_login() ){
            basic_redir( $GLOBALS["home_url"] ) ;
        }
        if( isset( $info["idx"] ) ){
            $boiler = new routes_model();
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
                basic_redir( $GLOBALS["routes_url"] ) ;
            }
        }
    }
}
