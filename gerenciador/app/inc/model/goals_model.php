<?php 
class goals_model extends DOLModel{
	protected $field = array( " idx " , " name " , " complete " , " points " , " cpf " , " mes ", "tipo" ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "goals" , $bd );
	}
}