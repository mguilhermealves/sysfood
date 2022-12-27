<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SERVER["DOCUMENT_ROOT"] = dirname( __FILE__ ) . "/../html/" ;
$_SERVER["HTTP_HOST"] = "gerenciador.vendamaissanther.com.br";
putenv('SERVER_PORT=443');
putenv('SERVER_PROTOCOL=https');

// $_SERVER["DOCUMENT_ROOT"] = dirname( __FILE__ ) . "/../httpdocs/" ;
// $_SERVER["HTTP_HOST"] = "gerenciador.lovers-avert.local/";
// putenv('SERVER_PORT=80');
// putenv('SERVER_PROTOCOL=http');

putenv('SERVER_NAME='.$_SERVER["HTTP_HOST"]);
putenv('SCRIPT_NAME=index.php') ;
set_include_path( $_SERVER["DOCUMENT_ROOT"]  . PATH_SEPARATOR . get_include_path());
require_once( $_SERVER["DOCUMENT_ROOT"] . "../app/inc/main.php");

$users = new users_model();
$users->set_filter( array( " active = 'yes' " , " num_cartao is null ", " idx not in (select users_id from users_profiles where profiles_id = '1') " ) );
$users->set_paginate( array( 10 ) );
$users->load_data();

foreach( $users->data as $v ){  
    if (!empty($v["cpf"]) && !empty($v["mail"]) && !empty($v["first_name"])) {
        $body = array(
            'nome' => $v["first_name"] . ' ' . $v["last_name"],
            'cpf_cnpj' => $v["cpf"],
            'email' => $v["mail"],
            'senha' => $v["cpf"],
            'Id_ClienteCampanha' => constant("cCampanhaID"),
        );

        $response = externalapi_controller::load($body, 'cadastro');

        if (isset($response["error"]) && !$response["error"]) {
            $users1 = new users_model();
            $users1->set_filter(array(" cpf = '" . $v["cpf"] . "' "));
            $users1->populate(array("num_cartao" => $response["cartao"]["cartao"]));
            $users1->save();
        } else {
            $users1 = new users_model();
            $users1->set_filter(array(" cpf = '" . $v["cpf"] . "' "));
            $users1->populate(array("num_cartao" => 'ERRO'));
            $users1->save();
        }
    }
}
