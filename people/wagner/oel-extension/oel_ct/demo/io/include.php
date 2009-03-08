<?php
  echo '===> ', $argv[1], "\n";
  var_dump(include(basename($argv[1])));
?>
