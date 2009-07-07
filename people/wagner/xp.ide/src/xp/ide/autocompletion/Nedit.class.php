<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.autocompletion';
  
  uses(
    'xp.ide.ClassPathScanner'
  );

  /**-
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·autocompletion·Nedit extends Object {

    /**
     * initialize extra class pathes
     *
     */
    #[@init]
    public function classpathes() {
      create(new xp·ide·ClassPathScanner())->fromCwd();
    }

    /**
     * output all suggestions
     *
     * @param   string[] suggestions
     */
    #[@output]
    public function suggest(array $suggestions) {
      Console::$out->write(implode(PHP_EOL, $suggestions));
      return 0;
    }

  }
?>
