<?php
  require('common.inc.php');
  
  // {{{ main
  if (!file_exists($argv[1])) {
    exit('*** File "'.$argv[1].'" does not exist!');
  }
  
  $fd= fopen($argv[1], 'rb');
  $v= oel_read_header($fd);
  echo '===> OEL version= ', $v, "\n";
  
  $ops= oel_read_op_array($fd);
  echo "---> Op array= {\n", oparray_string($ops), "}\n";
  fclose($fd);
  
  echo "---> Executing...\n";
  $r= oel_execute($ops);

  echo "===> Done, returns ";
  var_dump($r);
  // }}}
?>
