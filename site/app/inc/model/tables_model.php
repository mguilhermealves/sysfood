<?php
class tables_model extends DOLModel {
	protected $field = array(" idx " , " created_at " , " created_by " , " modified_at " , " modified_by " , " removed_at " , " removed_by " , " name " , " description ", " qtd_chairs ", " position " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "tables" , $bd );
	}
}
?>