<?php
  $op= oel_new_op_array();
  oel_set_source_file($op, 'hello.php');
  oel_set_source_line($op, 1);
  oel_push_value($op, "Hello\n");
  oel_add_echo($op);
  
  oel_set_source_line($op, 2);
  oel_finalize($op);
  
  $fd= fopen('hello.php', 'wb');
  oel_write_header($fd);
  oel_write_op_array($fd, $op);
  fclose($fd);
?>
