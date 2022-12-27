<?php
class site_controller
{
	public function logout()
	{
		unset($_SESSION[constant("cAppKey")]);
		basic_redir($GLOBALS["home_url"]);
	}

	public static function check_login()
	{
		return isset($_SESSION[constant("cAppKey")]["credential"]["idx"]) && (int)$_SESSION[constant("cAppKey")]["credential"]["idx"] > 0;
	}

	public function display($info)
	{
		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");

		include(constant("cRootServer") . "ui/includes/navbar.php");

		//BANNERS
		$banners = new banners_model();
		$banners->set_field(array("idx", "img", "active"));
		$banners->set_filter(array("active = 'yes'"));
		$banners->set_order(array(" idx desc "));
		$banners->load_data();

		//TIPOS DE TRATAMENTOS
		$typestreatments = new typestreatments_model();
		$typestreatments->set_order(array(" idx ASC "));
		$typestreatments->load_data();

		//DEPOIMENTOS
		$testimonials = new testimonials_model();
		$testimonials->set_order(array(" idx ASC "));
		$testimonials->load_data();
		$testimonials->join("units", 'units', array("idx" => "unit"), null, array("idx", "trade_name"));

		include(constant("cRootServer") . "ui/page/index.php");

		include(constant("cRootServer") . "ui/common/footer.php");

		include(constant("cRootServer") . "ui/common/foot.php");
		print("<script>");
		include(constant("cRootServer") . "furniture/js/app.js");
		print('</script>' . "\n");
	}

	public function display_english($info)
	{
		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");

		include(constant("cRootServer") . "ui/includes/english/navbar.php");
		include(constant("cRootServer") . "ui/page/english/index.php");

		include(constant("cRootServer") . "ui/common/footer.php");

		include(constant("cRootServer") . "ui/common/foot.php");
		print("<script>");
		include(constant("cRootServer") . "furniture/js/app.js");
		print('</script>' . "\n");
	}

	public function password($info)
	{
		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/common/head.php");
		include(constant("cRootServer") . "ui/page/password.php");
		include(constant("cRootServer") . "ui/common/foot.php");
	}

	public function login($info)
	{
		if (isset($info["post"]["login"]) && isset($info["post"]["password"])) {
			$users = new users_model();
			$users->set_filter(array(" ( '" . $users->con->real_escape_string($info["post"]["login"]) . "' in (mail,login) or '" . $users->con->real_escape_string(preg_replace("/[^0-9]+?/", "", $info["post"]["login"])) . "' = cpf ) ", " password in ( '" . $users->con->real_escape_string(md5($info["post"]["password"])) . "' , '" . $users->con->real_escape_string(md5(preg_replace("/[^0-9]+?/", "", $info["post"]["login"]))) . "' ) "));
			$users->set_paginate(array(" 1 "));
			$users->load_data();
			if (isset($users->data[0]["idx"])) {
				$users->attach(array("profiles"), false, null, array("idx", "name", "editabled"));
				$users->attach(array("distributors"), false, null, array("idx", "name"));
				$_SESSION[constant("cAppKey")] = array(
					"credential" => current($users->data)
				);
				$users->populate(array("last_login" => date("Y-m-d H:i:s")));
				$users->save();
			} else {
				$_SESSION["messages_app"]["warning"] = array("Login e/ou Senha informados não conferem");
			}
		} else {
			$_SESSION["messages_app"]["warning"] = array("Login e/ou Senha são obrigatórios para realizar o login");
		}
		basic_redir($GLOBALS["home_url"]);
		exit();
	}

	public function pdf($info)
	{
		$file = 'img/Manual%20de%20instruncao-AAR-T1801%20rev2.pdf';
		$quoted = sprintf('"%s"', addcslashes(basename($file), '"\\'));
		$size   = filesize($file);

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $quoted);
		header('Content-Transfer-Encoding: binary');
		header('Connection: Keep-Alive');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . $size);
		readfile($file);
	}
}
