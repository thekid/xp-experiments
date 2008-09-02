<?php

  $op_a= oel_new_op_array();
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "oA");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_end_variable_parse($op_a);
  oel_add_call_method_name($op_a, 0);
  oel_add_free($op_a);
  oel_finalize($op_a);

  class classA {
    public function methA() { var_dump("called methA by name"); }
  }

  $a= "methA";
  $oA= new classA();
  oel_execute($op_a);

?>
