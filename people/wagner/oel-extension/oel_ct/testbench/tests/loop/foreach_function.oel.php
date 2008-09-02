<?php

  $op_a= oel_new_op_array();

  oel_add_call_function($op_a, 0, "arr");
  oel_add_begin_foreach($op_a);
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "value");
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "key");
  oel_add_begin_foreach_body($op_a);
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "key");
    oel_add_end_variable_parse($op_a);
    oel_add_echo($op_a);
    oel_push_value($op_a, " => ");
    oel_add_echo($op_a);
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "value");
    oel_add_end_variable_parse($op_a);
    oel_add_echo($op_a);
    oel_push_value($op_a, " --- ");
    oel_add_echo($op_a);
  oel_add_end_foreach($op_a);

  oel_finalize($op_a);

  function arr() {
    return array(
      "key1" => "value1",
      "key2" => "value2",
      "key3" => "value3",
      "key4" => "value4",
      "key5" => "value5",
    );
  }

  oel_execute($op_a);

?>
