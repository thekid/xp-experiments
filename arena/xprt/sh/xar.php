<?php 
  require('lang.base.php'); 
  xp::sapi('cli'); 
  uses('util.Properties');

  $cl= ClassLoader::getDefault()->registerPath($argv[1]);
  $pr= Properties::fromString($cl->getResource('META-INF/manifest.ini'));
  exit(XPClass::forName($pr->readString('archive', 'main-class'), $cl)->getMethod('main')->invoke(NULL, array(array_slice($argv, 2)))); 
?>
