<?php 
class musics_model extends DOLModel{
	protected $field = array( " idx " , " created_at ", " created_by ", " modified_at ", " modified_by ", " removed_at ", " active ", " slug ",  " music ", " banda ") ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "musics" , $bd );
	}
}