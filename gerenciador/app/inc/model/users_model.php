<?php
class users_model extends DOLModel {
	protected $field = array( " idx " , " enabled ", " mail " , " login " , " first_name " , " last_name " , " cpf " , " last_login " , " phone " , " celphone " , " units_id " , " genre " , " city " , " uf " , " accept_at ", "parent", "uuid" ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "users" , $bd );
	}

	// function save( $info  = array() ){
	// 	if(  isset( $info["idx"] ) && (int)$info["idx"] > 0 ){
	// 		$this->set_filter(array(" idx = '" . $info["idx"] . "' "));
	// 		$this->load_data();

	// 		$cartao = isset( $this->data[0] ) && empty($this->data[0]["num_cartao"]);
		
	// 		if( !empty( constant("cCampanhaID") ) ){
	// 			if($cartao){	
	// 				$body = array(
	// 					'nome' => $info["post"]["first_name"] . ' ' . $info["post"]["last_name"],
	// 					'cpf_cnpj' => preg_replace("/\D+?/","",$info["post"]["cpf"]),
	// 					'email' => $info["post"]["mail"],
	// 					'senha' => preg_replace("/\D+?/","",$info["post"]["cpf"]),
	// 					'Id_ClienteCampanha' => constant("cCampanhaID"),
	// 				);
	// 				$response = externalapi_controller::load($body, 'cadastro');
	// 				if (isset($response["error"]) && !$response["error"]) {
	// 					$this->set_filter(array(" idx = '" . $info["idx"] . "' "));
	// 					$this->populate(array("num_cartao" => $response["cartao"]["cartao"]));
	// 					$this->save();
	// 				}
	// 			}
	// 			if ($info["post"]["enabled"] == "no") {
	// 				$body = array(
	// 					'num_cartao' => $this->data[0]["num_cartao"]
	// 				);

	// 				$response = externalapi_controller::load($body, 'desabilitarcartao');
	// 			}
	// 		}
	// 	}
	// 	return parent::save( $info );
	// }


}
?>