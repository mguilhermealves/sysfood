<?php
class certifications_controller {
	public function display(){

        include( constant("cRootServer") . "ui/common/header.php");
        include( constant("cRootServer") . "ui/common/head.php");

        include(constant("cRootServer") . "ui/includes/navbar.php");
        include( constant("cRootServer") . "ui/page/certifications.php");

		include( constant("cRootServer") . "ui/common/foot.php");
		include( constant("cRootServer") . "ui/common/footer.php");
	}

    public function display_english(){

        include( constant("cRootServer") . "ui/common/header.php");
        include( constant("cRootServer") . "ui/common/head.php");

        include(constant("cRootServer") . "ui/includes/english/navbar.php");
        include( constant("cRootServer") . "ui/page/english/certifications.php");

		include( constant("cRootServer") . "ui/common/foot.php");
		include( constant("cRootServer") . "ui/common/footer.php");
	}
}
