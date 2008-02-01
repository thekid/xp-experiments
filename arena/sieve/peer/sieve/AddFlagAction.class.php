<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.sieve.Action');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class AddFlagAction extends peer·sieve·Action {
    
    /**
     * Pass tags and arguments
     *
     * @param   array<string, *> tags
     * @param   *[] arguments
     */
    public function pass($tags, $arguments) {
      if (!empty($tags)) {
        throw new IllegalArgumentException('Redirect takes no tagged arguments');
      }
      $this->flags= $arguments[0];
    }
  }
?>
