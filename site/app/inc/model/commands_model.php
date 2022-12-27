<?php
class commands_model extends DOLModel {
	protected $field = array(" idx " , " tables_id " , " client_name "  ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "commands" , $bd );
	}
}
?>