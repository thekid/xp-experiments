<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.sieve.action.Action', 'peer.mail.InternetAddress');

  /**
   * The "forward" implementation
   *
   * @see      xp://peer.sieve.Action
   * @purpose  Action implementation
   */
  class ForwardAction extends peer·sieve·action·Action {
    protected
      $target= NULL;

    /**
     * Pass tags and arguments
     *
     * @param   array<string, *> tags
     * @param   *[] arguments
     */
    public function pass($tags, $arguments) {
      if (!empty($tags)) {
        throw new IllegalArgumentException('Forward takes no tagged arguments');
      }
      $this->target= $arguments[0];
    }
    
    /**
     * Get target address
     *
     * @return  string
     */
    public function getTarget() {
      return $this->target;
    }
    
    /**
     * Get target address
     *
     * @return  peer.mail.InternetAddress
     */
    public function getTargetAddress() {
      return InternetAddress::fromString($this->target);
    }
    
    /**
     * Creates a string representation of this action.
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(->'.$this->target.')';
    }
  }
?>
