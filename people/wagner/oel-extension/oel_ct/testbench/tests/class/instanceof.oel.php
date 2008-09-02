<?php

  $op_a= oel_new_op_array();

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_end_variable_parse($op_a);
  oel_add_instanceof($op_a, "AClassA");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "c");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_finalize($op_a);

  abstract class AClassA {}
  class ClassA extends AClassA {}
  class ClassB {}

  $a= new ClassA();
  oel_execute($op_a);
  var_dump($c);

  $a= new ClassB();
  oel_execute($op_a);
  var_dump($c);

?>
