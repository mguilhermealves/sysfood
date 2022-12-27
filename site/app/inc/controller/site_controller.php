<?php
class site_controller
{
	public static function logout()
	{
		unset($_SESSION[constant("cAppKey")]);
		basic_redir($GLOBALS["home_url"]);
	}

	public static function check_login()
	{
		if (!isset($_SESSION[constant("cAppKey")]["credential"])) {
			return false;
		} else {
			return true;
		}
	}

	public static function error($info)
	{
		$title = $info["title"];
		$msg = $info["msg"];
		$done = isset($info["done"]) ? $info["done"] :  $GLOBALS["home_url"];
		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/error.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function display($info)
	{
		if (site_controller::check_login()) {
			$page = 'dashboard';

			$countTables = tables_controller::countTables();
			$countOccupied = tables_controller::countOccupied();
			$countLibered = tables_controller::countLibered();

			$tables = new tables_model();
			$tables->set_filter(array(" active = 'yes' "));
			$tables->load_data();
			$dataTables = $tables->data;

			include(constant("cRootServer") . "ui/common/header.inc.php");
			include(constant("cRootServer") . "ui/common/head.inc.php");
			include(constant("cRootServer") . "ui/components/dashboard/dashboard.php");
			include(constant("cRootServer") . "ui/common/footer.inc.php");
			include(constant("cRootServer") . "ui/common/foot.inc.php");
		} else {
			include(constant("cRootServer") . "ui/common/header.inc.php");
			include(constant("cRootServer") . "ui/common/head.inc.php");

			include(constant("cRootServer") . "ui/components/login/login.php");

			include(constant("cRootServer") . "ui/common/foot.inc.php");
		}
	}

	public function forgotPassword($info)
	{
		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");

		//$page = 'dashboard';

		include(constant("cRootServer") . "ui/components/login/forgot_password/forgot_password.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}

	public function reset_password($info)
	{
		$user = new users_model();
		$user->set_filter(array(" ( mail = '" . $user->con->real_escape_string($info["post"]["text"]) . "' or cpf = '" . $user->con->real_escape_string($info["post"]["text"]) . "' ) "));
		$user->load_data();
		if (isset($user->data[0])) {
			$user->attach(array("tokens"));
			if (isset($user->data[0]["tokens_attach"][0])) {
				$tokens_name = $user->data[0]["tokens_attach"][0]["name"];
			} else {
				$tokens_name = md5(date("YmdHis") . $user->data[0]["idx"]);
				$tokens = new tokens_model();
				$tokens->populate(array("name" => $tokens_name));
				$tokens->save();
				$info["idx"] = $tokens->con->insert_id;
				$info["post"]["users_id"] = $user->data[0]["idx"];
				$tokens->save_attach($info, array("users"), true);
			}

			$page = strtr(file_get_contents(constant("cRootServer") . "furniture/mail/nova-senha.html"), array(
				"#HOST#" => constant("cFurniture") . "mail/", "#SITE#" => constant("cTitle"), "#NOME#" => $user->data[0]["first_name"], "#LOGIN#" => $user->data[0]["mail"], "#LINK#" => sprintf($GLOBALS["tkpwd_url"], $tokens_name)
			));

			$messages_model = new messages_model();
			$messages_model->populate(array(
				"name" => "Renovação da Senha", "scheduled_at" => date("Y-m-d H:i:s"), "mailboxes" => serialize(array(
					"Address" => array("name" => $user->data[0]["first_name"], "mail" => $user->data[0]["mail"]), "from" => array("name" => constant("mail_from_name"), "mail" => constant("mail_from_mail")), "replyTo" => array("name" => constant("mail_from_name"), "mail" => constant("mail_from_mail"))
				)), "htmlmsg" => $page, "textmsg" => strip_tags($page), "type" => "mail"
			));
			$messages_model->save();
			$_SESSION["messages_app"]["info"] = array("Processo de reenvio de senha enviado para o seu e-mail");
		} else {
			$_SESSION["messages_app"]["warning"] = array("Não foi localizado em nossa base de dados dados com o e-mail cadastrado");
		}
		basic_redir($GLOBALS["home_url"]);
		exit();
	}


	public function login($info)
	{
		if (isset($info["post"]["login"]) && isset($info["post"]["password"])) {
			$users = new users_model();
			$users->set_filter(array(" login = '" . $users->con->real_escape_string($info["post"]["login"]) . "' ", " password = '" . $users->con->real_escape_string(md5($info["post"]["password"])) . "' ", " idx in ( select users_profiles.users_id from users_profiles, profiles where profiles.active = 'yes' and users_profiles.active = 'yes' and profiles.idx = users_profiles.profiles_id ) "));
			$users->set_paginate(array(" 1 "));
			$users->load_data();

			if (isset($users->data[0]["idx"])) {
				$users->attach(array("profiles"), false, " limit 1 ");

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
	}

	public static function change_companie($info)
	{
		$_SESSION[constant("cAppKey")]["companie_id"] = $info["post"]["companie_id"];
	}

	// public function loginwithlink( $info ){
	// 	$users = new users_model();
	// 	$users->set_filter( array( " active = 'yes' " , " md5( concat( idx, login ) ) = '" . $info["slug"] . "' " , " idx in ( select users_profiles.users_id from users_profiles, profiles where users_profiles.active = 'yes' and profiles.active = 'yes' and users_profiles.profiles_id = profiles.idx and profiles.adm = 'yes' ) "  ) ) ;
	// 	$users->set_paginate( array( " 1 " ) ) ;
	// 	$users->load_data();
	// 	if( isset( $users->data[0]) ){
	// 		$users->attach( array("profiles") , false , " limit 1 " );
	// 		$_SESSION[ constant("cAppKey") ] = array(
	// 			"credential" => current( $users->data )
	// 		) ;
	// 	}
	// 	else{
	// 		unset( $_SESSION[ constant("cAppKey") ] );
	// 	}
	// 	basic_redir( $GLOBALS["home_url"] );
	// 	exit();
	// }
}
