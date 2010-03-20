<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.Folder', 
    'io.collections.FileCollection', 
    'io.collections.iterate.FilteredIOCollectionIterator',
    'io.collections.iterate.ExtensionEqualsFilter'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class AllTests extends Object {
    
    public static function main(array $args) {
      $f= new Folder(ClassLoader::getDefault()->findResource('VERSION')->path, '../ports/unittest');
      foreach (new FilteredIOCollectionIterator(new FileCollection($f), new ExtensionEqualsFilter('.ini')) as $f) {
        Console::writeLine($f->getURI());
      }
    }
  }
?>
