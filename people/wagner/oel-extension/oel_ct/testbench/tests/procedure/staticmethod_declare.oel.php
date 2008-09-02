<?php

  $op_a= oel_new_op_array();
  oel_add_begin_class_declaration($op_a, "classA");
  oel_new_method($op_a, "methA", FALSE, TRUE);
  oel_add_end_class_declaration($op_a);
  oel_finalize($op_a);
  oel_execute($op_a);

  $c= new ReflectionClass("classA");
  var_dump($c->hasMethod("methA"));
  $cm= $c->getMethod("methA");
  var_dump($cm->isStatic());

?>
