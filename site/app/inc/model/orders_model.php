<?php 
class orders_model extends DOLModel{
	protected $field = array( " idx " , " created_at " , " created_by " , " modified_at " , "modified_by " , " emission_at " , " emission_by ", " expirated_at ",  " value ", " tax ", " type ", " has_balance_request ", " has_issued ", " issued_at ", " issued_by ",  " has_processed " , "processed_at", "processed_by", " active ", " companie_id ", " timeline ") ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "orders" , $bd );
	}
}
