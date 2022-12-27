<?php 
class goalstypes_model extends DOLModel {
	protected $field = array( " idx " , " name " , " slug " , " context ") ;
	
	protected $filter = array( " active = 'yes' " ) ;

	function __construct( $bd = false  ) {
		return parent::__construct( "goalstypes" , $bd );
	}
}