<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.sieve';

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
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
        "%s@{\n  required= %s\n  commandset= %s\n}",
        $this->getClassName(),
        str_replace("\n", "\n  ", xp::stringOf($this->required)),
        str_replace("\n", "\n  ", xp::stringOf($this->commandset))
      );
    }
  }
?>
