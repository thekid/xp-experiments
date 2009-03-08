<?php
  function oparray_string($ops, $indent= '  ') {
    if (!is_resource($ops)) {
      echo $indent;
      var_dump($ops);
      return;
    }
    foreach (oel_export_op_array($ops) as $opline) {
      printf(
        "%s@%-3d: <%03d> %s\n", 
        $indent,
        $opline->lineno,
        $opline->opcode->op,
        $opline->opcode->mne
      );
    }
  }
  
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
