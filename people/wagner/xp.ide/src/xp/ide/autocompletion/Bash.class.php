<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.autocompletion';
  
  uses(
    'util.cmd.Console',
    'xp.ide.ClassPathScanner'
  );

  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·autocompletion·Bash extends Object {

    /**
     * Constructor
     *
     */
    public function __construct() {
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
      return (int)array_reduce($suggestions, array($this, 'isClass'), FALSE);
    }

    /**
     * test if a suggestion is a class name
     *
     * @param   boolean aggregation so long
     * @param   string suggestion
     * @return  bool
     */
    private function isClass($aggregation, $suggestion) {
      return $aggregation || ('.' != substr($suggestion, -1));
    }

  }
?>
