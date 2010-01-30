<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.checks.Check');

  /**
   * Compiler checks
   *
   * @see   xp://xp.compiler.checks.Check
   */
  class Checks extends Object {
    protected $impl= array();
    
    /**
     * Add a check
     *
     * @param   xp.compiler.checks.Check impl
     * @param   bool error
     */
    public function add(Check $impl, $error) {
      $this->impl[]= array($impl->node(), $impl, $error);
    }

    /**
     * Verify a given node
     *
     * @param   xp.compiler.ast.Node in
     * @param   var messages
     * @return  bool whether to continue or not
     */
    public function verify(xp·compiler·ast·Node $in, $messages) {
      $continue= TRUE;
      foreach ($this->impl as $impl) {
        if (!$impl[0]->isInstance($in)) continue;
        if (!($message= $impl[1]->verify($in))) continue;
        if ($impl[2]) {
          $messages->error($message[0], $message[1], $in);
          $continue= FALSE;
        } else {
          $messages->warn($message[0], $message[1], $in);
        }
      }
      return $continue;
    }
  }
?>
