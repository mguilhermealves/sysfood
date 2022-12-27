<?php 
class goalsimports_model extends DOLModel{
	protected $field = array( " created_at " , " created_by " , " modified_at " , "modified_by " , "removed_at", "removed_by", "imported_at", "imported_by", "idx", " name " , " total " , " month " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "goalsimports" , $bd );
	}
}