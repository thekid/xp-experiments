<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.sieve.action.Action');

  /**
   * The "stop" implementation
   *
   * @see      xp://peer.sieve.Action
   * @purpose  Action implementation
   */
  class StopAction extends peer·sieve·action·Action {

    /**
     * Pass tags and arguments
     *
     * @param   array<string, *> tags
     * @param   *[] arguments
     */
    public function pass($tags, $arguments) {
      if (!empty($tags) || !empty($arguments)) {
        throw new IllegalArgumentException('Reject takes no arguments');
      }
    }
    
    /**
     * Creates a string representation of this action.
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName();
    }
  }
?>
