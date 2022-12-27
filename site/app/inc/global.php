<?php
date_default_timezone_set('America/Sao_Paulo');
define( "cPaginate" , 150 );
ini_set('post_max_size', '4096M');
ini_set('upload_max_filesize', '4096M');
ini_set('default_charset', 'UTF-8');

define ("cHStr", '172.29.0.2');
define ("cUserStr", 'user_sysfood');
define ("cPassStr", '123456');
define ("cBancoStr", 'mysql_sysfood');

define( "cURL_API" , "" );

define("prefix_tables" , "");

define( "cAppKey" , "sysfood" );
define( "cTitle" , "Sys Food" );

define( "cAppRoot" , "/" );
define( "cRootServer" ,  sprintf( "%s%s" , $_SERVER["DOCUMENT_ROOT"] , constant("cAppRoot") ) ) ;
define( "cRootServer_APP" ,  sprintf( "%s%s" , $_SERVER["DOCUMENT_ROOT"] , constant("cAppRoot") . "../app"  ) ) ;
define( "cFrontend" , sprintf( "http://%s%s" , $_SERVER["HTTP_HOST"] , constant("cAppRoot") ) );

define( "cFurniture" , sprintf( "%s%s" , constant("cFrontend") , "furniture/" ) );

define( "mail_from_port" , "" );
define( "mail_from_host" , "" );
define( "mail_from_user" , "" );
define( "mail_from_name" , "" );
define( "mail_from_pwd" , "" );

?>
