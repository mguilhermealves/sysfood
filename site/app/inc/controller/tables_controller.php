<?php
class tables_controller
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

	public static function countTables()
	{
		$tables = new tables_model();
		$tables->set_filter(array(" active = 'yes' "));
		$tables->load_data();

		return count($tables->data);
	}

	public static function countOccupied()
	{
		$tables = new tables_model();
		$tables->set_filter(array(" status = 'occupied' "));
		$tables->load_data();

		return count($tables->data);
	}

	public static function countLibered()
	{
		$tables = new tables_model();
		$tables->set_filter(array(" status = 'libered' "));
		$tables->load_data();

		return count($tables->data);
	}
}
