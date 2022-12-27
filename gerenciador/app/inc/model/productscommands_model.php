<?php
class productscommands_model extends DOLModel {
	protected $field = array(" idx " , " commands_id " , " products ", " observation ", " amount ", " qtd_unity ", " discount "  ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "productscommands" , $bd );
	}
}
?>