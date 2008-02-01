<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'peer.sieve';

  uses('peer.sieve.Condition', 'lang.IndexOutOfBoundsException');

  /**
   * (Insert class' description here)
   *
   * @purpose  Base class for all rules
   */
  class peer·sieve·ConditionComposite extends peer·sieve·Condition {
    public $conditions= array();
  
    /**
     * Returns the number of conditions this composite is composed of
     *
     * @return  int
     */
    public function numConditions() {
      return sizeof($this->conditions);
    }

    /**
     * Retrieve a condition at a given offset
     *
     * @param   int offset
     * @return  peer.sieve.Condition
     * @throws  lang.IndexOutOfBoundsException
     */
    public function conditionAt($offset) {
      if (!isset($this->conditions[$offset])) {
        throw new IndexOutOfBoundsException('Offset '.$offset.' out of bounds');
      }
      return $this->conditions[$offset];
    }
  }
?>
