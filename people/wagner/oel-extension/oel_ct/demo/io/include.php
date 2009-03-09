<?php
  require('common.inc.php');

  echo '===> ', $argv[1], "\n";
  var_dump(include($argv[1]));
?>
