<?php
class treatments_controller
{
	public function display($info)
	{
		$treatments = new treatments_model();
		$treatments->set_filter(array(" active = 'yes' "));
		$treatments->load_data();
		$treatments->join("typestreatments", 'typestreatments', array("idx" => "type"), null, array("idx", "name"));

		// print_pre($treatments->data, true);

		// $namepage = "Manuais";

		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");

		include(constant("cRootServer") . "ui/includes/navbar.php");
		include(constant("cRootServer") . "ui/page/tratamentos/tratamentos.php");

		include(constant("cRootServer") . "ui/common/foot.php");
		print("<script>");
		include(constant("cRootServer") . "furniture/js/treatments/treatments.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/footer.php");
	}

	public function search($info)
	{
		if ($info["post"]) {
			# code...
		}
		print_pre($info, true);
		$treatments = new treatments_model();
		$treatments->set_filter(array(" idx = '" . $info["idx"] . "' ", " active = 'yes' "));
		$treatments->set_field( array("idx", "name", "description", "video", "active", "manual_pdf", "video_file", "is_video"));
		$treatments->load_data();
		$data = current($treatments->data);

		if (!isset($data["idx"])) {
			basic_redir($GLOBALS["manuals_url"]);
		}

		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");

		include(constant("cRootServer") . "ui/includes/navbar.php");
		include(constant("cRootServer") . "ui/page/manuals/manual.php");

		include(constant("cRootServer") . "ui/common/footer.php");
		print("<script>");
		include(constant("cRootServer") . "furniture/js/treatments/treatment.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.php");
	}
}
