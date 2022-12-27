<?php 
class contacts_model extends DOLModel{
	protected $field = array( " idx " , " created_at " , " created_by " , " modified_at " , "modified_by " ," first_name " , " last_name " , " mail ", " office ", " address " , " number ", " complement " , " postalcode " , " district ", " city " , " uf " , " phone " , " ramal " , " phone2 " , " ramal2 " , " celphone ", " active " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "contacts" , $bd );
	}
} 
?>