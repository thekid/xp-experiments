<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.sieve';

  uses('lang.IndexOutOfBoundsException');

  /**
   * (Insert class' description here)
   *
   * @purpose  Value object
   */
  class peer·sieve·RuleSet extends Object {
    public
      $rules    = array();
      
    /**
     * Returns whether this ruleset is empty
     *
     * @return  bool
     */
    public function isEmpty() {
      return 0 === sizeof($this->rules);
    }

    /**
     * Returns size of this ruleset
     *
     * @return  int
     */
    public function size() {
      return sizeof($this->rules);
    }

    /**
     * Retrieve a rile at a given offset
     *
     * @param   int offset
     * @return  peer.sieve.Condition
     * @throws  lang.IndexOutOfBoundsException
     */
    public function ruleAt($offset) {
      if (!isset($this->rules[$offset])) {
        throw new IndexOutOfBoundsException('Offset '.$offset.' out of bounds');
      }
      return $this->rules[$offset];
    }
  }
?>
