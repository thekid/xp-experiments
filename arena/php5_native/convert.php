<?php
/* This file is part of the XP framework
 *
 * $Id$ 
 */

  require('lang.base.php');
  xp::sapi('cli');
  uses(
    'io.File',
    'io.FileUtil',
    'io.Folder',
    'net.xp_framework.tophp5.MigrationDoclet',
    'io.collections.FileCollection',
    'io.collections.iterate.FilteredIOCollectionIterator',
    'io.collections.iterate.RegexFilter'
  );
  
  // Params
  $p= &new ParamString();
  
  // Display help
  if ($p->exists('help', 'h') || !$p->exists(1)) {
    Console::writeLine(<<<EOH
usage: convert.php <source-path> [<trarget-path> [<base-path>]]

  source-path     The path to the XP skeleton SOURCE directory
  target-path     The path to the XP skeleton TARGET directoy (defaults
                  to "skeleton2")

  base-path       The path, relative from skeleton directory, to start
                  with migration (if omitted the complete skeleton
                  directory will be migrated)
EOH
    );
    exit();
  }
 
  $base= realpath($p->value(1));
  $targetdir= $p->value(2, 2, 'skeleton2');
  $collection= &new FileCollection($base.'/'.$p->value(3, 3, ''));
  $collection->open();
  
  $iterator= &new FilteredIOCollectionIterator($collection,
    new RegexFilter('#\.class\.php$#'),
    TRUE
  );
  while ($iterator->hasNext()) {
    xp::gc();
    $element= &$iterator->next();
    
    // Construct classname from that
    $relative= substr($element->getURI(), strlen($base)+ 1);
    $fqcn= strtr(substr($relative, 0, -10), DIRECTORY_SEPARATOR, '.');
    
    // Skip existing files
    $folder= &new Folder(dirname($targetdir.DIRECTORY_SEPARATOR.$relative));
    if (!$folder->exists()) {
      Console::write('p');
      $folder->create();
    }
    
    $target= &new File($targetdir.DIRECTORY_SEPARATOR.$relative);
    if ($target->exists()) {
      Console::write('s');
      continue;
    }
    
    try(); {
    
      // Kind of hackish, but RootDoc expects a ParamString
      $param= &new ParamString();
      $param->setParams(array(NULL, $fqcn));
      
      $doclet= &new MigrationDoclet();
      RootDoc::start($doclet, $param);
    } if (catch('Exception', $e)) {
      fputs(STDERR, '*** Could not convert '.$fqcn.":\n");
      $e->printStackTrace();
      fputs(STDERR, "\n\n");
      Console::write('E');
      xp::gc();
      continue;
    }
    
    FileUtil::setContents($target, $doclet->getOutput());
    Console::write('.');
    xp::gc();
  }
?>