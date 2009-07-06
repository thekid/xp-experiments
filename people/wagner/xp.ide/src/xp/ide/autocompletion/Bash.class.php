<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.autocompletion';
  
  uses(
    'util.cmd.Command',
    'xp.ide.autocompletion.PackageCompleter',
    'xp.ide.autocompletion.ClassCompleter'
  );

  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·autocompletion·Bash extends Object {

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    final public static function main(array $args) {
      $packagename= ($args ? $args[0] : '');
      $subpattern= '';
      $suggestions= array();

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

      Console::$out->write(implode(PHP_EOL, $suggestions));
      return 0;
    }

  }
?>
