<?php
class news_model extends DOLModel {
	protected $field = array(" idx " , " name " , " slug " , " headline " , " context " , " image " , " category " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "news" , $bd );
	}
}
?>