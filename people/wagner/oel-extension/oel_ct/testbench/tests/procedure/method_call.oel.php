<?php

  $op_a= oel_new_op_array();
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "oA");
  oel_add_call_method($op_a, 0, "methA");
  oel_add_free($op_a);
  oel_finalize($op_a);

  class classA {
    public function methA() { var_dump("called methA"); }
  }

  $oA= new classA();
  oel_execute($op_a);

?>
