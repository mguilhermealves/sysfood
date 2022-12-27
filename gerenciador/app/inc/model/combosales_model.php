<?php
class combosales_model extends DOLModel {
	protected $field = array(" idx " , " name " , " slug " , " month "  ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "combosales" , $bd );
	}
}
?>