<?php
include( $_SERVER["DOCUMENT_ROOT"] . "/../app/inc/global.php");
require_once( constant("cRootServer_APP") . "/inc/lists.php" ) ;
require_once( constant("cRootServer_APP") . "/inc/lib/common_function.php" ) ;
require_once( constant("cRootServer_APP") . "/inc/urls.php" ) ;
#if( ! isset( $_SESSION["site_orders"] ) ){
#	$_SESSION["site_orders"] = orders_controller::_create_tmp();
#	if( isset( $_COOKIE[ constant("cAppKey") . 'sggaID'] ) ){
#		$_SESSION["site_orders"]["gaID"] = $_COOKIE[ constant("cAppKey") . 'sggaID' ];
#	}
#}
#if( ! isset( $_SESSION["site_orders"]["gaID"] ) ){
#	$_SESSION["site_orders"]["gaID"] = generate_key(29)."-".generate_key(29);
#}
#$time = ( time() + ( 3 * 24 * 60 * 60 * 150 ) ) ;
#setcookie( constant("cAppKey") . 'sggaID',  $_SESSION["site_orders"]["gaID"] , $time ) ;
?>
