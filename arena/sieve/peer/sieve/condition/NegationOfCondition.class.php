<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.sieve.condition.Condition');

  /**
   * The "not" condition
   *
   * @purpose  Condition implementation
   */
  class NegationOfCondition extends peer·sieve·condition·Condition {
    public $negated= NULL;

    /**
     * Creates a string representation of this header condition
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.xp::stringOf($this->negated).')';
    }
  }
?>
