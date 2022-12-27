<?php
class contacts_controller
{
	public static function data4select($key = "idx", $filters = array(" active = 'yes' "), $field = "name")
	{
		$filed_name = ltrim(rtrim(preg_replace("/.+ as (.+)$/", "$1", $field)));
		$boiler = new contacts_model();
		$boiler->set_field(array($key, $field));
		$boiler->set_order(array(" idx desc "));
		$boiler->set_filter($filters);
		$boiler->load_data();
		$out = array();
		foreach ($boiler->data as $value) {
			$out[$value[$key]] = $value[$filed_name];
		}
		return $out;
	}

	private function filter($info)
	{
		//
	}

	public function display($info)
	{
		//
	}

	public function form($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		if (isset($info["idx"])) {
			$contact = new contacts_model();
			$contact->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$contact->load_data();
			$data = current($contact->data);

			$form = array(
				"title" => "Editar Contato",
				"url" => sprintf($GLOBALS["contact_url"], $info["idx"])
			);
		} else {
			$data = array();
			$form = array(
				"title" => "Cadastrar Contato",
				"url" => $GLOBALS["newcontact_url"]
			);
		}

		$page = 'Contato';

		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/contacts/contact.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		print("<script>");
		// print('$("button[name=\'btn_back\']").bind("click", function(){');
		// print(' document.location = "' . (isset($info["get"]["done"]) ? $info["get"]["done"] : sprintf($GLOBALS["client_url"], $info["clients_id"])) . '" ');
		// print('})' . "\n");
		include(constant("cRootServer") . "furniture/js/contacts/contact.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function save($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		$contact = new contacts_model();

		$info["post"]["postalcode"] = preg_replace("/[^0-9]/", "", $info["post"]["postalcode"]);
		$info["post"]["phone"] = preg_replace("/[^0-9]/", "", $info["post"]["phone"]);
		$info["post"]["phone2"] = preg_replace("/[^0-9]/", "", $info["post"]["phone2"]);
		$info["post"]["celphone"] = preg_replace("/[^0-9]/", "", $info["post"]["celphone"]);

		if (isset($info["idx"]) && (int)$info["idx"] > 0) {
			$contact->set_filter(array(" idx = '" . $info["idx"] . "' "));
			$info["post"]["modified_at"] = date("Y-m-d H:i:s");
		}

		$contact->populate($info["post"]);
		$contact->save();

		if (!isset($info["idx"]) || (int)$info["idx"] == 0) {
			$info["idx"] = $contact->con->insert_id;
		}

		$contact->save_attach($info, array("clients"));

		$_SESSION["messages_app"]["success"] = array("Contato Cadastrado com sucesso.");

		if (isset($info["post"]["done"]) && !empty($info["post"]["done"])) {
			basic_redir($info["post"]["done"]);
		} else {
			basic_redir(sprintf($GLOBALS["client_url"], $info["post"]["clients_id"]));
		}
	}

	public function remove($info)
	{
		if (!site_controller::check_login()) {
			basic_redir($GLOBALS["home_url"]);
		}

		if (isset($info["idx"])) {
			$contact = new contacts_model();

			$contact->set_filter(array(" idx = '" . $info["idx"] . "' "));

			$contact->remove();
		}

		basic_redir(sprintf($GLOBALS["client_url"], $info["idx"]));
	}
}
