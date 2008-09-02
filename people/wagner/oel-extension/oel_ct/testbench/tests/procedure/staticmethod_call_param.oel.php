<?php

  $op_a= oel_new_op_array();
  oel_push_value($op_a, "paramA");
  oel_add_call_method_static($op_a, 1, "methA", "classA");
  oel_add_free($op_a);
  oel_finalize($op_a);

  $op_b= oel_new_op_array();
  oel_add_begin_variable_parse($op_b);
  oel_push_variable($op_b, "b");
  oel_add_end_variable_parse($op_b);
  oel_add_call_method_static($op_b, 1, "methB", "classA");
  oel_add_free($op_b);
  oel_finalize($op_b);

  $op_c= oel_new_op_array();
  oel_add_begin_variable_parse($op_c);
  oel_push_variable($op_c, "c");
  oel_add_end_variable_parse($op_c);
  oel_add_call_method_static($op_c, 1, "methC", "classA");
  oel_add_free($op_c);
  oel_finalize($op_c);

  class classA {
    public static function methA($a) { var_dump($a, "called methA"); }
    public static function methB($a) { var_dump($a, "called methB"); }
    public static function methC(&$a) { var_dump($a, "called methC"); $a= NULL; }
  }

  $b= "paramB";
  $c= "paramC";

  oel_execute($op_a);
  oel_execute($op_b);
  oel_execute($op_c);
  var_dump($c);

?>
