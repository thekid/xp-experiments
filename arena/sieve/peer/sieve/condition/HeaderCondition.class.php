<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('peer.sieve.condition.Condition');

  /**
   * The "header" condition
   *
   * @purpose  Condition implementation
   */
  class HeaderCondition extends peer·sieve·condition·Condition {
    public
      $matchtype = NULL,
      $names     = array(),
      $keys      = array();

    /**
     * Creates a string representation of this header condition
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        '%s(%s [%s] ["%s"])',
        $this->getClassName(),
        xp::stringOf($this->matchtype),
        implode(', ', $this->names),
        implode('", "', $this->keys)
      );
    }
  }
?>
