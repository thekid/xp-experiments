<?php

  $op_a= oel_new_op_array();
  oel_add_call_method_static($op_a, 0, "methA", "classA");
  oel_add_free($op_a);
  oel_finalize($op_a);

  class classA {
    public static function methA() { var_dump("called methA"); }
  }

  oel_execute($op_a);

?>
