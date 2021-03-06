<?php
  require('lang.base.php');
  xp::sapi('cli');
  uses(
    'lang.archive.Archive',
    'io.File'
  );
  
  // {{{ void addClass(io.cca.Archive package, io.Stream name, string name
  //     Adds specified class to package using the classloader
  function addClass($package, $stream, $name) {
    Console::writeLine('---> Adding ', $name);
    $package->add($stream, strtr($name, '.', '/'). '.class.php');
  }
  // }}}
  
  // {{{ main
  $p= new ParamString();
  if (!$p->exists(1) || $p->exists('help', '?')) {
    Console::writeLine(<<<__
Packages a bean class for deployment

Usage:
$ php package.php <class-name> [ -o <package-file>] [-a file:file:...]

* class-name is the fully-qualified class name of the bean
  to package

* package-file is the package's filename and defaults to the
  class name + ".xar"

* files are additional files to pack into the archive, seperated
  by the path separator (":" on Un*x, ";" on Windows)
__
    );
    exit(1);
  }
  
  $classname= $p->value(1);
  $cl= ClassLoader::getDefault();

  // Load bean class
  try {
    $class= $cl->loadClass($classname);
    if (!$class->hasAnnotation('bean')) {
      Console::writeLine('*** ', $classname, ' is not a bean!');
      exit(-2);
    }

    $type= $class->getAnnotation('bean', 'type');
    $name= $class->getAnnotation('bean', 'name');
  } catch(ClassNotFoundException $e) {
    $e->printStackTrace();
    exit(-1);
  }
  
  // Calculate package name (including trailing ".")
  $pos= strrpos($classname, '.');
  $package= substr($classname, 0, $pos).'.';
  $short= substr($classname, $pos+ 1);
  
  // Generate remote interface
  with ($rstr= new Stream()); {
    $rstr->open(STREAM_MODE_WRITE);
    $interface= basename($name);
    $rstr->write("<?php\n");

    // Add classes used in type hints to uses()
    $uses= array('remote.beans.BeanInterface' => TRUE);
    foreach ($class->getMethods() as $method) {
      foreach ($method->getArguments() as $argument) {
        $uses[$argument->getType(TRUE)]= TRUE;
      }
    }
    unset($uses['array']);
    unset($uses[NULL]);
    $rstr->write("  uses('".implode("', '", array_keys($uses))."');\n");

    $rstr->write('  interface '.$interface." extends BeanInterface {\n");
    foreach ($class->getMethods() as $method) {
      if (!$method->hasAnnotation('remote')) continue;

      $rstr->write("    /**\n");
      foreach ($method->getArguments() as $argument) {
        $rstr->write('     * @param  '.$argument->getType().' '.$argument->getName()."\n");
      }
      $rstr->write('     * @return '.$method->getReturnType()."\n");
      $rstr->write("     */\n");
      $rstr->write('    public function '.$method->getName(TRUE).'(');
      $args= '';
      foreach ($method->getArguments() as $argument) {
        $args.= xp::reflect($argument->getType(TRUE)).' $'.$argument->getName().', ';
      }
      $rstr->write(rtrim($args, ', ').");\n");
    }
    $rstr->write("  }\n?>");
    $rstr->close();
  }
  
  // Generate bean implementation
  with ($istr= new Stream()); {
    $istr->open(STREAM_MODE_WRITE);
    $implementation= $short.'Impl';
    $istr->write("<?php\n");
    $istr->write("  uses('".$package.$short.'\', \''.$package.$interface."');\n");
    $istr->write('  class '.$implementation.' extends '.$short.' implements '.$interface." {}\n");
    $istr->close();
  }

  // Create meta information  
  $meta= new Stream();
  $meta->open(STREAM_MODE_WRITE);
  $meta->write("[bean]\n");
  $meta->write('class="'.$package.$implementation.'"'."\n");
  $meta->write('remote="'.$package.$interface.'"'."\n");
  $meta->write('lookup="'.$name.'"'."\n");
  $meta->close();
  
  // Package it
  $a= new Archive(new File($p->value('output', 'o', $classname.'.xar')));
  Console::writeLine('===> Packaging ', $classname, ' into ', $a->toString());
  try {
    $a->open(ARCHIVE_CREATE);
    
    // Add meta information
    $a->add($meta, 'META-INF/bean.properties');
    
    // Add additional files
    foreach (array_filter(explode(PATH_SEPARATOR, $p->value('add', 'a', ''))) as $filename) {
      Console::writeLine('---> ', $filename);

      $f= new File($filename);
      $f->exists() && $a->add($f, $filename);
    }
    
    // Add: Bean class, remote interface, and home interface
    $a->addFileBytes(strtr($classname, '.', '/'). '.class.php', '', '', $class->getClassLoader()->loadClassBytes($classname));
    addClass($a, $rstr, $package.$interface);
    addClass($a, $istr, $package.$implementation);

    $a->create();
  } catch(XPException $e) {
    $e->printStackTrace();
    exit(-1);
  }

  Console::writeLine('===> Done');
  // }}}
?>
