<?php
  function __error($code, $msg, $file= NULL, $line= -1) {
    echo '[err#', $code, ']: ', $msg, "\n";
  }
  set_error_handler('__error');

  var_dump("anfang");
  __error(E_WARNING, 'Op array execution was ended by a call to exit');
  var_dump("ende");

  var_dump("anfang");
  echo "lalala";
  
  __error(E_WARNING, 'Op array execution was ended by a call to exit');
  var_dump("ende");
?>
