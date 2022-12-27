<?php
class respostas_model extends DOLModel {
	protected $field = array(" idx " , " name " , " resposta " , " acertos " , " pontos " , " created_by " , " created_at ") ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "respostas" , $bd );
	}
}
?>