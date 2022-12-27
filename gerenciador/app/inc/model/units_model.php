<?php 
class units_model extends DOLModel{
	protected $field = array( " idx " , "created_at", "created_by", "modified_at", "modified_by", "removed_at", "removed_by", "active", "company_name", "trade_name", "cnpj", "phone", "celphone", "mail", "postalcode", "address", "number", "complement", "district", "city", "uf" ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "units" , $bd );
	}
}