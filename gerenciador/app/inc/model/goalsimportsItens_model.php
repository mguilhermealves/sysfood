<?php 
class goalsimportsItens_model extends DOLModel{
	protected $field = array( " created_at " , " created_by " , " modified_at " , "modified_by " , "removed_at", "removed_by", " nome " , " cpf " , " tipo ", " pontuacao ", "goalsimports_id" ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "goalsimportsitens" , $bd );
	}
}
?> 