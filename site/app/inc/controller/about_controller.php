<?php
class about_controller {
	public function display(){

        $namepage = "Sobre";

        include( constant("cRootServer") . "ui/common/header.php");
        include( constant("cRootServer") . "ui/common/head.php");

        include(constant("cRootServer") . "ui/includes/navbar.php");
        include( constant("cRootServer") . "ui/page/about.php");

		include( constant("cRootServer") . "ui/common/foot.php");
		include( constant("cRootServer") . "ui/common/footer.php");
	}
}
