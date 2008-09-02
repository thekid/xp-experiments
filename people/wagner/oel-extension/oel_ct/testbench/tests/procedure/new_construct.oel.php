<?php

  $op_a= oel_new_op_array();
  oel_push_value($op_a, "wertA");
  oel_add_new_object($op_a, 1, "classA");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "oA1");
  oel_add_assign($op_a);
  oel_add_free($op_a);
  oel_finalize($op_a);


  class classA {
    public $propA= NULL;

    public function __construct($a) {
      $this->propA= $a;
    }
  }

  oel_execute($op_a);
  var_dump($oA1);

?>
