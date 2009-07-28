<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.resolve';
  
  uses(
    'lang.XPClass',
    'util.collections.HashTable'
  );

  /**
   * Find a class in the source tree
   *
   * @purpose  IDE
   */
  class xp·ide·resolve·Runner extends Object {

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    public static function main(array $args) {
      $class= XPClass::forName('xp.ide.resolve.'.array_shift($args));
      $resolver= $class->newInstance();

      $outputMethod=   NULL;
      $statusMethod=   NULL;
      foreach ($class->getMethods() as $method) {
        if ($method->hasAnnotation('output')) $outputMethod= $method;
        if ($method->hasAnnotation('status')) $statusMethod= $method;
      }

      $result= array_map(array($resolver, 'getSourceFileUri'), $args);
      if (!is_null($outputMethod)) $outputMethod->invoke($resolver, array($result));
      if (!is_null($statusMethod)) return $statusMethod->invoke($resolver, array($result));
      return 0;
    }
  }
?>
