<?php
class users_model extends DOLModel {
	protected $field = array( " idx " , " enabled ", " first_name " , " last_name " , " cpf " , " mail " , " login " , " last_login " , " phone " , " celphone " , " genre " , " postalcode ", " address ", " number ", " complement ", " district ", " city " , " uf " , " created_at " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "users" , $bd );
	}
}
?>