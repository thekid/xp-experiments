<?php
  require('lang.base.php');
   
  $fd= fopen('input.Try.class', 'rb');
  var_dump(bcompiler_read($fd));
  fclose($fd);
  
  // Tell classloader we've loaded the class
  xp::$registry['class.input·Try']= 'input.Try';
  xp::$registry['classloader.input.Try']= 'bcompiler://'.$argv[1];

  $class= XPClass::forName('input.Try');

  echo xp::stringOf($class), '::main()= ';
  var_dump(input·Try::main());
?>
