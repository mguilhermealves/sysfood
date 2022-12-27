<?php
class libraries_model extends DOLModel {
	protected $field = array(" idx " , " name " , " slug " , " headline " , " context " , " image " , " category ", "created_at", "imagem_banner" ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "libraries" , $bd );
	}
}
?>