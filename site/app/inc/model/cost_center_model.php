<?php 
class cost_center_model extends DOLModel{
	protected $field = array( " idx " , " created_at " , " created_by " , " modified_at " , " modified_by " ," removed_at " , " removed_by " , " active " , " name " , " slug " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "cost_center", $bd );
	}
} 
?>