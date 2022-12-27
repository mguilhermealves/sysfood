<?php 
class clients_model extends DOLModel{
	protected $field = array( " idx " , " created_at " , " created_by " , " modified_at " , "modified_by " , " first_name " , " last_name " , " cpf " , " phone ", " address " , " number ", " complement " , " postalcode " , " district ", " city " , " uf " , " active " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "clients" , $bd );
	}
} 
?>