<?php 
  require('lang.base.php'); 

  exit(lang::XPClass::forName($argv[1])->getMethod('main')->invoke(NULL, array(array_slice($argv, 2)))); 
?>
