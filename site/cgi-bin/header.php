<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SERVER["DOCUMENT_ROOT"] = dirname( __FILE__ ) . "/../httpdocs/" ;
$_SERVER["HTTP_HOST"] = "gerenciador.aartelecom.local";
putenv('SERVER_PORT=80');
putenv('SERVER_PROTOCOL=http');

putenv('SERVER_NAME='.$_SERVER["HTTP_HOST"]);
putenv('SCRIPT_NAME=index.php') ;
set_include_path( $_SERVER["DOCUMENT_ROOT"]  . PATH_SEPARATOR . get_include_path());
require_once( $_SERVER["DOCUMENT_ROOT"] . "../app/inc/main.php");
?>