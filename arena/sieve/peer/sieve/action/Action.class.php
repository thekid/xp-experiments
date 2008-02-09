<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.sieve';
  
  uses('peer.sieve.Command');

  /**
   * A sieve action
   *
   * @see      xp://peer.sieve.Command
   * @purpose  Command implementation
   */
  abstract class peer·sieve·Action extends peer·sieve·Command {

    /**
     * Pass tags and arguments
     *
     * @param   array<string, *> tags
     * @param   *[] arguments
     */
    public abstract function pass($tags, $arguments);
  }
?>
