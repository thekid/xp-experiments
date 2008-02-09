<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('peer.sieve.condition.Condition');

  /**
   * The "true" and "false" conditions
   *
   * @purpose  Condition implementation
   */
  class BooleanCondition extends peer·sieve·condition·Condition {
    public
      $value= NULL;

    /**
     * Constructor
     *
     * @param   bool
     */
    public function __construct($value) {
      $this->value= $value;
    }

    /**
     * Creates a string representation of this header condition
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.xp::stringOf($this->value).')';
    }
  }
?>
