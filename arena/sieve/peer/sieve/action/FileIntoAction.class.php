<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.sieve.action.Action');

  /**
   * The "fileinto" implementation
   *
   * @see      xp://peer.sieve.Action
   * @purpose  Action implementation
   */
  class FileIntoAction extends peer·sieve·action·Action {

    /**
     * Pass tags and arguments
     *
     * @param   array<string, *> tags
     * @param   *[] arguments
     */
    public function pass($tags, $arguments) {
      if (!empty($tags)) {
        throw new IllegalArgumentException('Fileinto takes no tagged arguments');
      }
      $this->mailbox= $arguments[0];
    }
    
    /**
     * Creates a string representation of this action.
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(->'.$this->mailbox.')';
    }
  }
?>
