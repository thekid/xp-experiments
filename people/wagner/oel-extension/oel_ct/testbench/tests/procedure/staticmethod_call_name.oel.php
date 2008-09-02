<?php

  $op_a= oel_new_op_array();
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_end_variable_parse($op_a);
  oel_add_call_method_name_static($op_a, 0, "classA");
  oel_add_free($op_a);
  oel_finalize($op_a);

  class classA {
    public static function methA() { var_dump("called methA by name"); }
  }

  $a= "methA";
  oel_execute($op_a);

?>
