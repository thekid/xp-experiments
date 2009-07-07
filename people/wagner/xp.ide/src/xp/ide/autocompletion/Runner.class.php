<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.autocompletion';
  
  uses(
    'lang.XPClass',
    'xp.ide.autocompletion.PackageCompleter',
    'xp.ide.autocompletion.ClassCompleter'
  );
  
  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·autocompletion·Runner extends Object {

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    public static function main(array $args) {
      $class= XPClass::forName(array_shift($args));
      $inst= $class->newInstance();
      
      $packagename= ($args ? $args[0] : '');
      $subpattern= '';
      $suggestions= array();

      $initMethod= NULL;
      $outputMethod= NULL;
      foreach ($class->getMethods() as $method) {
        if ($method->hasAnnotation('init')) $initMethod= $method;
        if ($method->hasAnnotation('output')) $outputMethod= $method;
      }
      if (!is_null($initMethod)) $initMethod->invoke($inst);

      if (!ClassLoader::getDefault()->providesPackage($packagename)) {
        if (FALSE === strrpos($packagename, '.')) {
          $subpattern= $packagename;
          $packagename= '';
        } else {
          $subpattern= substr($packagename, 1 + strrpos($packagename, '.'));
          $packagename= substr($packagename, 0, strrpos($packagename, '.'));
        }
      }

      $suggestions= array_merge(
        create(new xp·ide·autocompletion·PackageCompleter($packagename, $subpattern))->suggest(),
        create(new xp·ide·autocompletion·ClassCompleter($packagename, $subpattern))->suggest()
      );

      if (!is_null($outputMethod)) return $outputMethod->invoke($inst, array($suggestions));
      return 1;
    }

  }
?>
