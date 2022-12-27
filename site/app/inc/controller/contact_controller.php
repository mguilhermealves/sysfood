<?php
class contact_controller
{
	public function display()
	{

		$namepage = "Contatos";

		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");

		include(constant("cRootServer") . "ui/includes/navbar.php");
		include(constant("cRootServer") . "ui/page/contact.php");

		include(constant("cRootServer") . "ui/common/foot.php");
		print("<script>");
		include(constant("cRootServer") . "furniture/js/contact.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/footer.php");
	}

	public function display_english()
	{

		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");

		include(constant("cRootServer") . "ui/includes/english/navbar.php");
		include(constant("cRootServer") . "ui/page/english/contact.php");

		include(constant("cRootServer") . "ui/common/foot.php");
		print("<script>");
		include(constant("cRootServer") . "furniture/js/contact.js");
		print('</script>' . "\n");
		include(constant("cRootServer") . "ui/common/footer.php");
	}

	public function send($info)
	{
		$page = strtr(file_get_contents(constant("cRootServer") . "furniture/email/contato.html"), array(
			"#HOST#" => constant("cFurniture") . "email/",
			"#NOME#" => $info['post']['name'],
			"#MAIL#" => $info['post']['mail'],
			"#PHONE#" => $info['post']['phone'],
			"#SUBJECT#" => $info['post']['subject'],
			"#DESCRIPTION#" => $info['post']['description'],
		));

		$messages_model = new messages_model();
		$messages_model->populate(array(
			"name" => "Contato - AAR Telecom",
			"scheduled_at" => date("Y-m-d H:i:s"),
			"mailboxes" => serialize(array(
				"Address" => array(
					"name" => 'Lucyane AAR Telecom',
					"mail" => 'lucyane@aartelecom.com'
				),
				"from" => array(
					"name" => 'Lucyane AAR Telecom',
					"mail" => 'lucyane@aartelecom.com'
				),
				"replyTo" => array(
					"name" => 'Lucyane AAR Telecom',
					"mail" => 'lucyane@aartelecom.com'
				)
			)), "htmlmsg" => $page, "textmsg" => strip_tags($page),
			"type" => "mail"
		));
		$messages_model->save();

		$_SESSION["messages_app"]["success"] = array("Contato enviado com sucesso");

		basic_redir($GLOBALS["contato_url"]);
	}
}
