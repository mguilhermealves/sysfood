<?php
class manuals_controller
{
	public function display($info)
	{
		$manuals = new manuals_model();
		$manuals->set_filter(array(" active = 'yes' "));
		$manuals->load_data();
		$manuals->attach(array("qrcodes"));
		$data = $manuals->data;

		$namepage = "Manuais";

		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");

		include(constant("cRootServer") . "ui/includes/navbar.php");
		include(constant("cRootServer") . "ui/page/manuals/manuals.php");

		include(constant("cRootServer") . "ui/common/foot.php");
		print("<script>");
		include(constant("cRootServer") . "furniture/js/manuals.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/footer.php");
	}

	public function display_english($info)
	{
		$manuals = new manuals_model();
		$manuals->set_filter(array(" active = 'yes' "));
		$manuals->load_data();
		$manuals->attach(array("qrcodes"));
		$data = $manuals->data;

		$namepage = "Manuais";

		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");

		include(constant("cRootServer") . "ui/includes/english/navbar.php");
		include(constant("cRootServer") . "ui/page/english/manuals/manuals.php");

		include(constant("cRootServer") . "ui/common/foot.php");
		print("<script>");
		include(constant("cRootServer") . "furniture/js/manuals.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/footer.php");
	}

	public function detail($info)
	{
		$manual = new manuals_model();
		$manual->set_filter(array(" idx = '" . $info["idx"] . "' ", " active = 'yes' "));
		$manual->set_field( array("idx", "name", "description", "video", "active", "manual_pdf", "video_file", "is_video"));
		$manual->load_data();
		$data = current($manual->data);

		$video = unserialize($data["video_file"]);

		if (!isset($data["idx"])) {
			basic_redir($GLOBALS["manuals_url"]);
		}

		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");

		include(constant("cRootServer") . "ui/includes/navbar.php");
		include(constant("cRootServer") . "ui/page/manuals/manual.php");

		include(constant("cRootServer") . "ui/common/footer.php");
		print("<script>");
		include(constant("cRootServer") . "furniture/js/manuals/manual.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.php");
	}
}
