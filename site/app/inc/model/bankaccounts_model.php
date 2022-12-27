<?php 
class bankaccounts_model extends DOLModel{
	protected $field = array( " idx " , " created_at " , " created_by " , " modified_at " , "modified_by " , " name " , " agency_number " , " agency_digit " , " account_number " , " account_digit ", " bank_number ", " type ") ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "bankaccounts" , $bd );
	}
} 
?>