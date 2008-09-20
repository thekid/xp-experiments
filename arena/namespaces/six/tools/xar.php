<?php 
  require('lang.base.php'); 

  $cl= lang::ClassLoader::registerLoader(new lang::archive::ArchiveClassLoader($argv[1]));
  $pr= util::Properties::fromString($cl->getResource('META-INF/manifest.ini'));
  exit(lang::XPClass::forName($pr->readString('archive', 'main-class'), $cl)->getMethod('main')->invoke(NULL, array(array_slice($argv, 2)))); 
?>
