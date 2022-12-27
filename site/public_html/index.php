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
	"sr" => isset( $_GET["sr"] ) ? $_GET["sr"] > 1 ? $_GET["sr"] : 0 : 0 ,
	"format" => ".html" ,
	"post" => isset( $_POST ) ? $_POST : NULL ,
	"get" => isset( $_GET ) ? $_GET : NULL ,
);
$btn_save = isset( $_POST["btn_save"] ) ? true : null ;
$btn_remove = isset( $_POST["btn_remove"] ) ? true : null ;

$strCanal = "";
$dispatcher = new dispatcher( true ) ;
$dispatcher->add_route ( "GET" , "/(index(\.json|\.xml|\.html)).*?" , "function:basic_redir" , null, $home_url ) ;
$dispatcher->add_route ( "GET" , "/?" , "site_controller:display" , null, $params ) ;

/* TRATAMENTOS */
$dispatcher->add_route ( "GET" , "/tratamentos" , "treatments_controller:display" , null, $params ) ;
$dispatcher->add_route ( "POST" , "/tratamentos" , "treatments_controller:search" , null, $params ) ;
$dispatcher->add_route ( "GET" , "/tratamentos/tratamento-corporal" , "treatments_controller:corporal" , null, $params ) ;
$dispatcher->add_route ( "GET" , "/tratamentos/depilacao-facial" , "treatments_controller:facial" , null, $params ) ;
$dispatcher->add_route ( "GET" , "/tratamentos/depilacao-a-laser" , "treatments_controller:laser" , null, $params ) ;

/* UNIDADES */
$dispatcher->add_route ( "GET" , "/unidades" , "units_controller:display" , null, $params ) ;

$dispatcher->add_route ( "GET" , "/produtos" , "manuals_controller:display" , null, $params ) ;

$dispatcher->add_route ( "GET" , "/certificacoes" , "certifications_controller:display" , null, $params ) ;

$dispatcher->add_route ( "GET" , "/manual/manual-show/(?P<idx>.+)" , "manuals_controller:detail" , null, $params ) ;
$dispatcher->add_route ( "GET" , "/manual/(?P<idx>.+)" , "manuals_controller:detail" , null, $params ) ;

$dispatcher->add_route ( "GET" , "/contato" , "contact_controller:display" , null, $params ) ;
$dispatcher->add_route ( "POST" , "/enviar_contato" , "contact_controller:send" , $btn_save, $params ) ;

if ( ! $dispatcher->exec() ) {
	basic_redir( $home_url );
}
?>
