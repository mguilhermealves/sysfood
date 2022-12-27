<?php
class categories_controller
{
	public static function data4select($key = "idx", $filters = array(" active = 'yes' "), $field = "name")
	{
		$product = new categories_model();
		$product->set_field(array($key, $field));
		$product->set_order(array(" name asc "));
		$product->set_filter($filters);
		$product->load_data();
		$out = array();
		foreach ($product->data as $value) {
			$out[$value[$key]] = $value[$field];
		}
		return $out;
	}
}
