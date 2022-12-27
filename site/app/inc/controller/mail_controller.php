<?php
class mail_controller{
	public static function save( $info ){
		$boiler = new messages_model();
		if( isset( $info["idx"] ) && $info["idx"] > 0 ){
			$boiler->set_filter( array( " idx = '" .  $boiler->con->real_escape_string( $info["idx"] ) . "' ") ) ;
		}
		$boiler->populate( $info["post"] , true ) ;
		$boiler->save() ;
		if( ! isset( $info["idx"] ) || $info["idx"] < 1 ){
			$info["idx"] = $boiler->con->insert_id ;
		}
        return $info ;
	}
}
?>