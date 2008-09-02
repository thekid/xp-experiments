<?php

  $op_a= oel_new_op_array();
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_return($op_a);
  oel_finalize($op_a);

  $op_b= oel_new_op_array();
  oel_add_begin_variable_parse($op_b);
  oel_push_variable($op_b, "b", "classA");
  oel_add_return($op_b);
  oel_finalize($op_b);

  $a= "valueA";
  class classA {
    public static $b= "valueB";
  }

  var_dump(oel_execute($op_a));
  var_dump(oel_execute($op_b));

?>
