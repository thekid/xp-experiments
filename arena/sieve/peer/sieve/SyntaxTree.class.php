<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.sieve';

  /**
   * Represents a sieve script's syntax tree
   *
   * @see      xp://peer.sieve.SieveParser#parse
   * @purpose  Value object
   */
  class peer·sieve·SyntaxTree extends Object {
    public $required= array();
    public $commandset= NULL;

    /**
     * Creates a string representation of this action.
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        "%s@{\n  required   : [%s]\n  commandset : %s\n}",
        $this->getClassName(),
        implode(', ', $this->required),
        str_replace("\n", "\n  ", xp::stringOf($this->commandset))
      );
    }
  }
?>
