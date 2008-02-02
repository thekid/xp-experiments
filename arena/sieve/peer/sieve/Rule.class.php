<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.sieve';

  uses('peer.sieve.Command');

  /**
   * Rule (if, elsif and else are rules)
   *
   * @see      xp://peer.sieve.Command
   * @purpose  Command implementation
   */
  class peer·sieve·Rule extends Object {
    public $condition= NULL;
    public $commands= NULL;

    /**
     * Creates a string representation of this action.
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        "%s@{\n  condition= %s\n  commands= %s\n}",
        $this->getClassName(),
        str_replace("\n", "\n  ", xp::stringOf($this->condition)),
        str_replace("\n", "\n  ", xp::stringOf($this->commands))
      );
    }
  }
?>
