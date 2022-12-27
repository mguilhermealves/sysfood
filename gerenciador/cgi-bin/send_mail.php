<?php
require_once(  dirname( __FILE__ ) . "/_header.php");
$mail_controller = new mail_controller();
$mail_controller->send();
?>
