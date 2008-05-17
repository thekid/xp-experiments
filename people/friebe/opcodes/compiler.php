<?php
  while ($l= fgets(STDIN, 1024)) {
    $target= trim($l);
    if (!is_file($target)) {
      echo "- Does not exist: <", $target, ">\n";
      continue;
    }
  
    $name= tempnam('.', 'comp');
    $f= fopen($name, 'wb');
    bcompiler_write_header($f);
    bcompiler_write_file($f, $target);
    bcompiler_write_footer($f);
    fclose($f);
    echo "+ ", $name, "\n";
  }
?>
