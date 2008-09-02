<?php

  $op_a= oel_new_op_array();

  oel_push_value($op_a, "exeptA");
  oel_add_new_object($op_a, 1, "Exception");
  oel_add_throw($op_a);

  oel_finalize($op_a);

  try {
    oel_execute($op_a);
  } catch (Exception $e) {
    $trace= $e->getTrace();
    var_dump(
      dirname($trace[0]["file"]),
      $e->getMessage()
    );
  }

?>
