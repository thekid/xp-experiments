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
      $class= XPClass::forName(array_shift($args));
      $resolver= $class->newInstance();

      $resolveMethods= new HashTable();
      $outputMethod=   NULL;
      $statusMethod=   NULL;
      foreach ($class->getMethods() as $method) {
        if ($method->hasAnnotation('resolve', 'type')) $resolveMethods[XPClass::forName($method->getAnnotation('resolve', 'type'))]= $method;
        if ($method->hasAnnotation('output')) $outputMethod= $method;
        if ($method->hasAnnotation('status')) $statusMethod= $method;
      }
      $result= array();
      foreach ($args as $className) {
        $cp= ClassLoader::getDefault()->findClass($className);
        if ($cp instanceof NULL) continue;
        if (!isset($resolveMethods[$cp->getClass()])) continue;
        $result[]= $resolveMethods[$cp->getClass()]->invoke($resolver, array($cp, $className));
      }
      if (!is_null($outputMethod)) $outputMethod->invoke($resolver, array($result));
      if (!is_null($statusMethod)) return $statusMethod->invoke($resolver, array($result));
      return 0;
    }
  }
?>
