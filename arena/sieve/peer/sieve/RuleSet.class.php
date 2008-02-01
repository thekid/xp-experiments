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
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class peer·sieve·RuleSet extends Object {
    public
      $required = array(),
      $rules    = array();
      
    public function isEmpty() {
      return 0 === sizeof($this->rules);
    }

    public function ruleAt($offset) {
      if (!isset($this->rules[$offset])) {
        throw new IndexOutOfBoundsException('Offset '.$offset.' out of bounds');
      }
      return $this->rules[$offset];
    }
  }
?>
