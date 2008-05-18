<?php 
  require('lang.base.php'); 
  xp::sapi('cli'); 

  Console::writeLine('XP ', getenv('XPVERSION'), ' { PHP ', phpversion(), ' & ZE ', zend_version(), ' } @ ', php_uname());
  Console::writeLine('Copyright (c) 2001-2008 the XP group');
  foreach (ClassLoader::getLoaders() as $delegate) {
    Console::writeLine($delegate);
  }
?>
