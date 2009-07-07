<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.autocompletion';
  
  uses(
    'xp.ide.autocompletion.Bash',
    'lang.ClassLoader'
  );

  /**-
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·autocompletion·Nedit extends xp·ide·autocompletion·Bash {

    public static function main(array $args) {
      // search project classpath
      $csd= getcwd();
      $home= getenv('HOME');
      do {
        if ($paths= scanpath(array($csd), $home)) {
          foreach (explode(PATH_SEPARATOR, $paths) as $path) {
            ClassLoader::registerpath($path);
          }
          break;
        }
        $oldcsd= $csd;
        $csd= dirname($csd);
      } while ($oldcsd !== $csd);
      
      parent::main($args);
    }

  }
?>
