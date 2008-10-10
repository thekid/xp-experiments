<?php

  $op_a= oel_new_op_array();
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "oA");
  oel_push_value($op_a, "a");
  oel_push_value($op_a, "b");
  oel_push_value($op_a, "c");
  oel_add_call_method($op_a, 3, "methA");
  oel_add_free($op_a);
  oel_finalize($op_a);

  class classA {
    public function methA($a, $b, $c) { var_dump($c); }
  }

  $oA= new classA();
  oel_execute($op_a);

?>
