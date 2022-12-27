<?php
class typestreatments_model extends DOLModel {
	protected $field = array(" idx " , " name " , " description " , " image_banner ", "slug" ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "typestreatments" , $bd );
	}
}
?>