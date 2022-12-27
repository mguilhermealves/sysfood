<?php
class treatments_model extends DOLModel {
	protected $field = array(" idx " , " name " , " type " , " description " , " image_banner " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "treatments" , $bd );
	}
}
?>