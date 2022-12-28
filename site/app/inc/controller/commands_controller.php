<?php
class commands_controller
{
	public static function data4select($key = "idx", $filters = array(), $field = "name")
	{
		$tokens = new tokens_model();
		$tokens->set_field(array($key, $field));
		$tokens->set_filter($filters);
		$tokens->load_data();
		$out = array();
		foreach ($tokens->data as $value) {
			$out[$value[$key]] = $value[$field];
		}
		return $out;
	}

	public function display($info)
	{
		$table = new tables_model();
		$table->set_filter(array(" idx = " . $info["idx"] . " "));
		$table->load_data();
		$table->join("commands", "commands", array("tables_id" => "idx"), "and status = 'enabled'");
		$data = current($table->data);

		$categories = new categories_model();
		$categories->set_filter(array(" active = 'yes' "));
		$categories->load_data();
		$categories->attach(array("products"), true, "and active = 'yes'");

		// print_pre($categories->data, true);

		include(constant("cRootServer") . "ui/common/header.inc.php");
		include(constant("cRootServer") . "ui/common/head.inc.php");
		include(constant("cRootServer") . "ui/page/commands/command.php");
		include(constant("cRootServer") . "ui/common/footer.inc.php");
		include(constant("cRootServer") . "ui/common/foot.inc.php");
	}
}
