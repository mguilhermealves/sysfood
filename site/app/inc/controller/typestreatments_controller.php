<?php
class typestreatments_controller
{
  public static function data4select($key = "idx", $filters = array(), $field = "name")
  {
    $typestreatments = new typestreatments_model();
    $typestreatments->set_field(array($key, $field));
    $typestreatments->set_filter($filters);
    $typestreatments->load_data();
    $out = array();
    foreach ($typestreatments->data as $value) {
      $out[$value[$key]] = $value[$field];
    }
    return $out;
  }
}
