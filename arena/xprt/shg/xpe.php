<?php 
  require('lang.base.php'); 
  xp::sapi('cli'); 

  $src= $argv[1]; 
  $argv= array_slice($argv, 2); 
  
  exit(eval($src));
?>
