<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('peer.sieve.Condition');

  /**
   * (Insert class' description here)
   *
   * @purpose  Base class for all rules
   */
  class BooleanCondition extends peer·sieve·Condition {
    public
      $value= NULL;

    public function __construct($value) {
      $this->value= $value;
    }
  }
?>
