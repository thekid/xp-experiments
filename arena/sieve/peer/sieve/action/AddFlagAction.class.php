<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.sieve.action.Action');

  /**
   * The "addflag" action
   *
   * Syntax:
   * <pre>
   *   addflag [<variablename: string>] <list-of-flags: string-list>
   * </pre>
   *
   * @see      rfc://5232
   * @purpose  Action
   */
  class AddFlagAction extends peer·sieve·action·Action {
    public
      $flags    = array(),
      $variable = NULL;

    /**
     * Pass tags and arguments
     *
     * @param   array<string, *> tags
     * @param   *[] arguments
     */
    public function pass($tags, $arguments) {
      if (!empty($tags)) {
        throw new IllegalArgumentException('Addflag takes no tagged arguments');
      }
      
      $n= sizeof($arguments);
      if (2 === $n) {
        $this->flags= (array)$arguments[1]; 
        $this->variable= $arguments[0];
      } else if (1 === $n) {
        $this->flags= (array)$arguments[0];
      } else {
        throw new IllegalArgumentException('Addflag: Expecting either 1 or 2 arguments, '.$n.' given');
      }
    }
  }
?>
