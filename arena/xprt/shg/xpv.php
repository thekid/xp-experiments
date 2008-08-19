<?php 
  require('lang.base.php'); 
  xp::sapi('cli'); 

  Console::writeLinef(
    'XP %s { PHP %s & ZE %s } @ %s', 
    trim(ClassLoader::getDefault()->getResource('VERSION')),
    phpversion(),
    zend_version(),
    php_uname()
  );
  Console::writeLine('Copyright (c) 2001-2008 the XP group');
  foreach (ClassLoader::getLoaders() as $delegate) {
    Console::writeLine($delegate);
  }
?>
