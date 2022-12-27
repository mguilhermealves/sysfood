<?php
class combosalesgoals_model extends DOLModel {
	protected $field = array(" idx " , " name " , " point " , " combosales_id "  ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "combosalesgoals" , $bd );
	}
}
?>