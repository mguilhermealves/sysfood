<?php
class profiles_controller{
	public static function data4select( $key = "idx" , $filters = array( " active = 'yes' ") , $field = "name" ){
		$profiles = new profiles_model();
		$profiles->set_field( array( $key , $field  ) ) ;
		$profiles->set_filter( $filters ) ;
		$profiles->load_data();
		$out = array();
		foreach( $profiles->data as $value ){
			$out[ $value[ $key ] ] = $value[ $field ] ;
		}
		return $out ;
	}
	public function display( $info ){
		if( ! site_controller::check_login() ){
		basic_redir( $GLOBALS["home_url"] ) ;
		}
		$paginate = 10 ;
		$profiles = new profiles_model();

		$profiles->set_filter( array( " idx > 1 " ) ) ;
		$profiles->set_paginate( array( $info["sr"] , $paginate ) ) ;
		$profiles->load_data();
		$profiles->attach( array("users") , true , null , array("idx") );


		$total = $profiles->con->result( $profiles->con->select(" ifnull( count( idx ) , 0 ) as s" , " profiles " , "" ) , "s" , 0 ) ;		    
		// $users_lists = users_controller::data4select( "idx" , array( " idx in ( select users_profiles.users_id from users_profiles where users_profiles.active = 'yes' and users_profiles.profiles_id <= '2' ) ") , "name" ) ;

		$data = $profiles->data;
		$page = 'profiles';
		$form = array(
			"pattern" => array(
				"new" => $GLOBALS["newprofile_url"]
				, "action" => $GLOBALS["profile_url"]
				, "search" => !empty( $info["get"] ) ? set_url( $GLOBALS["profiles_url"], $info["get"] ) : $GLOBALS["profiles_url"] 
			)
		) ;
		include( constant("cRootServer") . "ui/common/header.inc.php");
		include( constant("cRootServer") . "ui/common/head.inc.php");
		include( constant("cRootServer") . "ui/page/profiles.php");
		include( constant("cRootServer") . "ui/common/footer.inc.php");
		include( constant("cRootServer") . "ui/common/foot.inc.php");
	}
	public function form( $info ){
		if( ! site_controller::check_login() ){
			basic_redir( $GLOBALS["home_url"] ) ;
		}
		if( isset( $info["slug"] ) ){
			$profiles = new profiles_model();
			$profiles->set_filter( array( " slug = '" . $info["slug"] . "' " ) ) ;
			$profiles->load_data();
			$data = current( $profiles->data );

			$data["categories"] = !empty( $data["categories"] ) ? unserialize( $data["categories"] ) : array() ;

			$form = array(
				"url" => sprintf( $GLOBALS["profile_url"] , $info["slug"] )
			) ;
		}
		else{
			$data = array( "categories" => array() );
			$form = array(
				"url" => $GLOBALS["newprofile_url"]
			) ;
		}
		$page = 'profile';
		$products = new products_model();
		$categories = $products->con->results( $products->con->select(" concat_ws(' - ' , code_front , name ) as category " , " products " , " group by concat_ws(' - ' , code_front , name ) order by concat_ws(' - ' , code_front , name ) " ) ) ;	
		include( constant("cRootServer") . "ui/common/header.inc.php");
		include( constant("cRootServer") . "ui/common/head.inc.php");
		include( constant("cRootServer") . "ui/page/profile.php");
		include( constant("cRootServer") . "ui/common/footer.inc.php");
		include( constant("cRootServer") . "ui/common/foot.inc.php");
	}
  	public function save( $info ){
		if( ! site_controller::check_login() ){
			basic_redir( $GLOBALS["home_url"] ) ;
		}
		$profiles = new profiles_model();
		if( isset( $info["slug"] ) ){
			$profiles->set_filter( array( " slug = '" . $info["slug"] . "' " ) ) ;
		}
		else{
			$info["post"]["slug"] = preg_replace("/-|_/" , "" , generate_slug( $info["post"]["name"] ) );
		}
		#print("aguarde...");
		#print( count( $info["post"]["categories"]  ) );
		#exit();
		$info["post"]["categories"] = serialize( !empty( $info["post"]["categories"] ) ? $info["post"]["categories"] : array() ) ;

		$profiles->populate( $info["post"] );
		$profiles->save();
		basic_redir( $GLOBALS["profiles_url"] ) ;
	}
}
