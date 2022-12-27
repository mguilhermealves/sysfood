<?php 
class distributors_model extends DOLModel{
	protected $field = array( " idx " , " name " , " cod_mtrix " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "distributors" , $bd );
	}
}