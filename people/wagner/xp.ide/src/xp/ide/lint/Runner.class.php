<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 $package= 'xp.ide.lint';
 
 uses(
   'util.cmd.Console',
   'lang.Process'
 );

  /**
   * check syntax
   *
   * @purpose  IDE
   */
  class xp·ide·lint·Runner extends Object {

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    public static function main(array $args) {
      $class= XPClass::forName(array_shift($args));
      $lint= $class->newInstance();

      $testMethod=    NULL;
      $sourceMethod=  NULL;
      $eLineMethod=   NULL;
      $eColumnMethod= NULL;
      $eTextMethod=   NULL;
      foreach ($class->getMethods() as $method) {
        if ($method->hasAnnotation('check'))       $testMethod= $method;
        if ($method->hasAnnotation('source'))      $sourceMethod= $method;
        if ($method->hasAnnotation('errorline'))   $eLineMethod= $method;
        if ($method->hasAnnotation('errorcolumn')) $eColumnMethod= $method;
        if ($method->hasAnnotation('errortext'))   $eTextMethod= $method;
      }

      if ($sourceMethod) {
        $source= '';
        while (!feof(STDIN)) $source.= fgets(STDIN);
        $sourceMethod->invoke($lint, array($source));
      }
      if ($testMethod) $testMethod->invoke($lint);
      Console::writeLine($eLineMethod ? $eLineMethod->invoke($lint): 0);
      Console::writeLine($eColumnMethod ? $eColumnMethod->invoke($lint) : 0);
      Console::write($eTextMethod ? $eTextMethod->invoke($lint) : 0);
    }
  }
?>
