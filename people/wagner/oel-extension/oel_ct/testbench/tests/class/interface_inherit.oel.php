<?php

  $op_a= oel_new_op_array();

  oel_add_begin_interface_declaration($op_a, "ClassA");
  oel_new_method($op_a, "methA");
  oel_add_end_interface_declaration($op_a);

  oel_add_begin_interface_declaration($op_a, "ClassB");
  oel_new_method($op_a, "methB");
  oel_add_end_interface_declaration($op_a);

  oel_add_begin_interface_declaration($op_a, "ClassC");
  oel_add_parent_interface($op_a, "ClassA");
  oel_add_parent_interface($op_a, "ClassB");
  oel_new_method($op_a, "methC");
  oel_add_end_interface_declaration($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

  $c= new ReflectionClass("ClassC");
  var_dump(
    $c->getMethods(),
    $c->getInterfaces(),
    $c->getParentclass()
  );

?>
