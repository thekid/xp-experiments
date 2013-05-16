<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.sieve.action.Action');

  /**
   * The vacation extension
   *
   * Syntax:
   * <pre>
   *   vacation [":days" number] [":subject" string]
   *    [":from" string] [":addresses" string-list]
   *    [":mime"] [":handle" string] <reason: string>
   * </pre>
   *
   * @test     xp://unittest.VacationExtensionTest
   * @see      rfc://5230
   * @purpose  Action
   */
  class VacationAction extends peer·sieve·action·Action {
    public 
      $reason    = NULL, 
      $days      = -1, 
      $subject   = NULL, 
      $from      = NULL, 
      $mime      = FALSE, 
      $handle    = NULL, 
      $addresses = array();

    /**
     * Pass tags and arguments
     *
     * @param   array<string, *> tags
     * @param   *[] arguments
     */
    public function pass($tags, $arguments) {
      $this->reason= $arguments[0];
      $this->days= isset($tags['days']) ? intval($tags['days']) : -1;
      $this->subject= isset($tags['subject']) ? $tags['subject'] : NULL;
      $this->from= isset($tags['from']) ? $tags['from'] : NULL;
      $this->mime= isset($tags['mime']) ? $tags['mime'] : FALSE;
      $this->handle= isset($tags['handle']) ? $tags['handle'] : NULL;
      $this->addresses= isset($tags['addresses']) ? $tags['addresses'] : array();
    }
    
  }
?>
