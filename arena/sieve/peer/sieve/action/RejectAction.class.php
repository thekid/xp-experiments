<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.sieve.action.Action');

  /**
   * The "reject" extension
   *
   * @see      http://ietfreport.isoc.org/idref/draft-ietf-sieve-refuse-reject/
   * @purpose  Action
   */
  class RejectAction extends peer·sieve·action·Action {
    public
      $reason= NULL;
    
    /**
     * Pass tags and arguments
     *
     * @param   array<string, *> tags
     * @param   *[] arguments
     */
    public function pass($tags, $arguments) {
      if (!empty($tags)) {
        throw new IllegalArgumentException('Reject takes no tagged arguments');
      }
      $this->reason= $arguments[0];
    }

    /**
     * Creates a string representation of this action.
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'("'.addcslashes($this->reason, "\0..\17").'")';
    }
  }
?>
