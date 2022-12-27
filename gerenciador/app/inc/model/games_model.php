<?php 
class games_model extends DOLModel{
	protected $field = array( " idx " , " finished " , " end_at " , " name " , " moviment " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "games" , $bd );
	}
}