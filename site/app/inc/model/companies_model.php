<?php 
class companies_model extends DOLModel{
	protected $field = array( " idx " , " created_at " , " created_by " , " modified_at " , "modified_by " , " name " , " fantasy_name ", " cnpj " , " insc_municipal ", " insc_estadual ", " phone ", " description ", " postalcode ", " address ", " number ", " complement ", " district ", " city ", " uf " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "companies" , $bd );
	}
} 
?>