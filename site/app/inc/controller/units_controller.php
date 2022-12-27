<?php
class units_controller
{
	public function display($info)
	{
		$units = new units_model();
		$units->set_filter(array(" active = 'yes' "));
		$units->load_data();

		$page = "Unidades";

		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");

		include(constant("cRootServer") . "ui/includes/navbar.php");
		include(constant("cRootServer") . "ui/page/units/units.php");

		include(constant("cRootServer") . "ui/common/foot.php");
		print("<script>");
		include(constant("cRootServer") . "furniture/js/unidades.js");
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
