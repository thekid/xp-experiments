<?php
  require('lang.base.php');
  xp::sapi('cli');
  uses(
    'util.invoke.aop.Instrumentation',
    'util.profiling.Timer'
  );
  
  // Install stream wrapper
  $p= new ParamString();
  if (!$p->exists('disable')) {
    XPClass::forName('aspects.PowerAspect');
  }
  
  // Register fqcns.xar
  ClassLoader::registerLoader(new ArchiveClassLoader(new ArchiveReader(
    dirname(__FILE__).DIRECTORY_SEPARATOR.'fqcns.xar'
  )));

  // Load binford class
  $t= new Timer();
  $t->start();
  XPClass::forName('util.Binford');
  XPClass::forName('info.binford6100.Date');
  $t->stop();
  
  // Create an instance
  $bf= new Binford($p->value(1, NULL, 6100));
  $bd= new info·binford6100·Date();  
  
  // Profiling
  Console::writeLinef('%s && %s - took %.3f seconds', $bf->toString(), $bd->toString(), $t->elapsedTime());
  var_dump(xp::registry('errors'));
?>
