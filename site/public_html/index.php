<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once( $_SERVER["DOCUMENT_ROOT"] . "/../app/inc/main.php");
if( isset( $_GET["logout"] ) && $_GET["logout"] == "yes" ){
	unset( $_SESSION[ constant("cAppKey") ] );
	basic_redir( $GLOBALS["home_url"] ) ;
}
$params = array(
	"sr" => isset( $_GET["sr"] ) && $_GET["sr"] > 1 ? $_GET["sr"] : 0 ,
	"format" => ".html" ,
	"post" => isset( $_POST ) ? $_POST : NULL ,
	"get" => isset( $_GET ) ? $_GET : NULL ,
);
$btn_save = isset( $_POST["btn_save"] ) ? $_POST["btn_save"] : false ;
$btn_remove = isset( $_POST["btn_remove"] ) ? $_POST["btn_remove"] : false ;

$dispatcher = new dispatcher( true ) ;
$dispatcher->add_route ( "GET" , "/(index(\.json|\.xml|\.html)).*?" , "function:basic_redir" , null, $home_url ) ;
$dispatcher->add_route ( "GET" , "/?" , "site_controller:display" , null, $params ) ;
$dispatcher->add_route ( "POST" , "/?" , "site_controller:login" , $btn_save, $params ) ;
$dispatcher->add_route ( "GET" , "/sair" , "site_controller:logout" , null, $params ) ;

/**esqueci minha senha */
$dispatcher->add_route ( "GET" , "/esqueci_minha_senha" , "site_controller:forgotPassword" , null, $params ) ;
$dispatcher->add_route ( "POST" , "/?" , "site_controller:reset_password" , $btn_save, $params ) ;


$dispatcher->add_route ( "GET" , "/?" , "site_controller:reset_password" , $btn_save, $params ) ;

/**token */

foreach( tokens_controller::data4select("idx", array( " active = 'yes' " ) , "name" ) as $k => $v ){
	$dispatcher->add_route ( "GET" , "/tkpwd/(?P<key>".$v.")" , "tokens_controller:display" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/tkpwd/(?P<key>".$v.")" , "tokens_controller:renew" , $btn_save, $params ) ;
}

$users = new users_model();
foreach( $users->_list_data("idx", array( " active = 'yes' " , " idx in ( select users_profiles.users_id from users_profiles, profiles where users_profiles.active = 'yes' and profiles.active = 'yes' and users_profiles.profiles_id = profiles.idx and profiles.adm = 'yes' ) " ) , " md5(concat(idx,login)) as name " ) as $k => $v ){
	$dispatcher->add_route ( "GET" , "/loginsenha/(?P<slug>".$v["name"].")" , "site_controller:loginwithlink" , null, $params ) ;
}
if( site_controller::check_login() ){
	$routes_model = new routes_model();
	$routes_model->set_filter( array( " sys_type = 'system' or ( sys_type = 'user' and idx in ( select routes_profiles.routes_id from routes_profiles where routes_profiles.active = 'yes' and routes_profiles.profiles_id in ('" . implode("','", isset( $_SESSION[ constant("cAppKey") ]["credential"]["profiles_attach"][0] ) ? array_column( $_SESSION[ constant("cAppKey") ]["credential"]["profiles_attach"] , "idx" ) : array(0) )  . "') ) ) " ) );
	$routes_model->set_order( array( "method" , "btncheck" ) );
	$routes_model->load_data();
	foreach( $routes_model->data as $k => $v ){
		$check = !empty( $v["btncheck"] ) ? $GLOBALS[ $v["btncheck"] ] : null ;
		$p = !empty( $v["params"] ) ? array_merge( $params , $GLOBALS[ $v["params"] ] ) : $params ;
		$dispatcher->add_route( $v["method"] , "/" .  $v["pattern"] , $v["controller"] , $check , $p ) ;
	}

	$dispatcher->add_route ( "POST" , "/consultar_cnpj" , "clients_controller:consultar_cnpj" , NULL, $params );

	/* EMPRESAS SOCIOS */
	$dispatcher->add_route ( "GET" , "/socios/empresa/(?P<companies_id>[0-9]+)" , "partners_controller:select_partners" , NULL, $params ) ;
	$dispatcher->add_route ( "POST" , "/cadastrar_socio" , "partners_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "POST" , "/socio/(?P<idx>[0-9]+)" , "partners_controller:remove" , $btn_remove, $params ) ;

	/* CLIENTES CONTATO */
	$dispatcher->add_route ( "GET" , "/cadastrar_contato/cliente/(?P<clients_id>[0-9]+)" , "contacts_controller:form" , NULL, $params ) ;
	$dispatcher->add_route ( "POST" , "/cadastrar_contato" , "contacts_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "POST" , "/contato/(?P<idx>[0-9]+)" , "contacts_controller:remove" , $btn_remove, $params ) ;
	$dispatcher->add_route ( "GET" , "/cliente/(?P<clients_id>[0-9]+)/contato/(?P<idx>[0-9]+)" , "contacts_controller:form" , NULL, $params ) ;
	$dispatcher->add_route ( "POST" , "/contato/(?P<idx>[0-9]+)" , "contacts_controller:save" , $btn_save, $params ) ;

	$dispatcher->add_route ( "POST" , "/change_companie" , "site_controller:change_companie" , NULL, $params ) ;
}
if ( ! $dispatcher->exec() ) {
	//print_pre( $dispatcher );
	basic_redir( $home_url );
}
?>