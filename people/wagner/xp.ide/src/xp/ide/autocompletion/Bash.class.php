<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.autocompletion';
  
  uses(
    'util.cmd.Console'
  );

  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·autocompletion·Bash extends Object {

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
