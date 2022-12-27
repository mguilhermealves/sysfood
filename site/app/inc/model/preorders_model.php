<?php 
class preorders_model extends DOLModel{
	protected $field = array( " idx " , " created_at " , " created_by " , " modified_at " , "modified_by " , " emission_at ", "tax", "value", " type ", " has_balance_request ", " active ") ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "preorders" , $bd );
	}
}
