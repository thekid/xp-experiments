<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.sieve.action.Action');

  /**
   * The notify extension
   *
   * Syntax:
   * <pre>
   *   notify [":from" string]
   *     [":importance" <"1" / "2" / "3">]
   *     [":options" string-list]
   *     [":message" string]
   *     <method: string>
   * </pre>
   *
   * Old syntax:
   * <pre>
   *   notify [":method" string]
   *     [":id" string]
   *     [":options" 1*(string-list / number)]
   *     [<":low" / ":normal" / ":high">]
   *     ["message:" string]
   * </pre>
   *
   * @test     xp://unittest.NotifyExtensionTest
   * @see      http://ietfreport.isoc.org/idref/draft-ietf-sieve-notify/
   * @purpose  Action
   */
  class NotifyAction extends peer·sieve·action·Action {
    public 
      $method     = NULL,
      $from       = NULL,
      $importance = -1,
      $options    = array(),
      $message    = NULL;
    
    /**
     * Pass tags and arguments
     *
     * @param   array<string, *> tags
     * @param   *[] arguments
     */
    public function pass($tags, $arguments) {
      $this->method= $arguments[0];
      $this->from= isset($tags['from']) ? $tags['from'] : NULL;
      $this->message= isset($tags['message']) ? $tags['message'] : NULL;
      $this->options= isset($tags['options']) ? $tags['options'] : array();
      $this->importance= isset($tags['importance']) ? intval($tags['importance']) : -1;
    }
  }
?>
