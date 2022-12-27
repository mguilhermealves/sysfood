<?php 
class partners_model extends DOLModel{
	protected $field = array( " idx " , " created_at " , " created_by " , " modified_at " , "modified_by " , " first_name " , " last_name " , " mail " , " document " , " rg ", " postalcode ", " address ", " number ", " complement ", " district ", " city ", " uf ", " active ") ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "partners" , $bd );
	}
} 
?>