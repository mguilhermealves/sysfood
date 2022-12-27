<?php
$home_url = constant("cFrontend") ;
$users_url = sprintf("%s%s" , constant("cFrontend")  , "usuarios" ) ;
$user_url = sprintf("%s%s/%s" , constant("cFrontend") , "usuario" , "%d" ) ;
$newuser_url = sprintf("%s%s" , constant("cFrontend") , "cadastrar_usuario" ) ;
$tkpwd_url = sprintf("%s%s/%s" ,  constant("cFrontend_USER") , "tkpwd" , "%s" ) ;

foreach( (array)urls_controller::data4select("slug",array(" idx > 0 ") , "pattern") as $k => $v ){
  $GLOBALS[ $k . "_url"] = constant("cFrontend") . $v;
}

$quizes_url = sprintf("%s%s" , constant("cFrontend")  , "quizes" ) ;
$quizresponse_url = sprintf("%s%s" , constant("cFrontend")  , "quiz_respostas" ) ;

$quiz_url = sprintf("%s%s/%s" , constant("cFrontend") , "quiz" , "%d" ) ;
$newquiz_url = sprintf("%s%s" , constant("cFrontend") , "cadastrar_quiz" ) ;

$news_url = sprintf("%s%s" , constant("cFrontend")  , "noticias" ) ;
$new_url = sprintf("%s%s/%s" , constant("cFrontend") , "noticia" , "%d" ) ;
$newnews_url = sprintf("%s%s" , constant("cFrontend") , "cadastrar_noticia" ) ;

$goals_url = sprintf("%s%s" , constant("cFrontend")  , "metas" ) ;
$goal_url = sprintf("%s%s/%s" , constant("cFrontend") , "meta" , "%d" ) ;
$newgoals_url = sprintf("%s%s" , constant("cFrontend") , "cadastrar_meta" ) ;

$categories_url = sprintf("%s%s" , constant("cFrontend")  , "categorias" ) ;
$category_url = sprintf("%s%s/%s" , constant("cFrontend") , "categoria" , "%d" ) ;

$distributors_url = sprintf("%s%s" , constant("cFrontend")  , "distribuidoras" ) ;
$distributor_url = sprintf("%s%s/%s" , constant("cFrontend") , "distribuidora" , "%d" ) ;
$newdistributors_url = sprintf("%s%s" , constant("cFrontend") , "cadastrar_distribuidora" ) ;

$previewimportgoals_url = sprintf("%s%s" , constant("cFrontend") , "preview_plan_metas" ) ;

?>