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
	
	$dispatcher->add_route ( "GET" , "/usuarios(?P<format>.html|.json|.xls)?" , "users_controller:display" , null, $params ) ;
	$dispatcher->add_route ( "GET" , "/usuario/(?P<idx>[0-9]+)" , "users_controller:form" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/usuario/(?P<idx>[0-9]+)" , "users_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "GET" , "/cadastrar_usuario" , "users_controller:form" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/cadastrar_usuario" , "users_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "POST" , "/usuario/(?P<idx>[0-9]+)" , "users_controller:remove" , $btn_remove, $params ) ;
	
	$dispatcher->add_route ( "GET" , "/quiz_respostas(?P<format>.html|.json|.xls)?" , "respostas_controller:display" , null, $params ) ;
	$dispatcher->add_route ( "GET" , "/quizes(?P<format>.html|.json)?" , "quizes_controller:display" , null, $params ) ;
	$dispatcher->add_route ( "GET" , "/quiz/(?P<idx>[0-9]+)" , "quizes_controller:form" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/quiz/(?P<idx>[0-9]+)" , "quizes_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "GET" , "/cadastrar_quiz" , "quizes_controller:form" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/cadastrar_quiz" , "quizes_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "POST" , "/quiz/(?P<idx>[0-9]+)" , "quizes_controller:remove" , $btn_remove, $params ) ;

	$dispatcher->add_route ( "GET" , "/noticias(?P<format>.html|.json)?" , "news_controller:display" , null, $params ) ;
	$dispatcher->add_route ( "GET" , "/noticia/(?P<idx>[0-9]+)" , "news_controller:form" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/noticia/(?P<idx>[0-9]+)" , "news_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "GET" , "/cadastrar_noticia" , "news_controller:form" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/cadastrar_noticia" , "news_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "POST" , "/noticia/(?P<idx>[0-9]+)" , "news_controller:remove" , $btn_remove, $params ) ;

	$dispatcher->add_route ( "GET" , "/metas(?P<format>.html|.json)?" , "goalstypes_controller:display" , null, $params ) ;
	$dispatcher->add_route ( "GET" , "/meta/(?P<idx>[0-9]+)" , "goalstypes_controller:form" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/meta/(?P<idx>[0-9]+)" , "goalstypes_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "GET" , "/cadastrar_meta" , "goalstypes_controller:form" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/cadastrar_meta" , "goalstypes_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "POST" , "/meta/(?P<idx>[0-9]+)" , "goalstypes_controller:remove" , $btn_remove, $params ) ;

	$dispatcher->add_route ( "GET" , "/distribuidoras(?P<format>.html|.json)?" , "distributors_controller:display" , null, $params ) ;
	$dispatcher->add_route ( "GET" , "/distribuidora/(?P<idx>[0-9]+)" , "distributors_controller:form" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/distribuidora/(?P<idx>[0-9]+)" , "distributors_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "GET" , "/cadastrar_distribuidora" , "distributors_controller:form" , null, $params ) ;
	$dispatcher->add_route ( "POST" , "/cadastrar_distribuidora" , "distributors_controller:save" , $btn_save, $params ) ;
	$dispatcher->add_route ( "POST" , "/distribuidora/(?P<idx>[0-9]+)" , "distributors_controller:remove" , $btn_remove, $params ) ;

	$dispatcher->add_route ( "POST" , "/preview_plan_metas" , "goalsimports_controller:preview" , null, $params ) ;

}

if ( ! $dispatcher->exec() ) {
	basic_redir( $home_url );
}
?>
