<?php
class testimonials_model extends DOLModel {
	protected $field = array(" idx " , " client_name " , " client_image " , " description " , " unit " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "testimonials" , $bd );
	}
}
?>