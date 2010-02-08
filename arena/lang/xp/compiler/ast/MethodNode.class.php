<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.RoutineNode');

  /**
   * Represents a method
   *
   */
  class MethodNode extends RoutineNode {
    public
      $modifiers  = 0,
      $returns    = NULL,
      $parameters = array();

    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      return 'xp.inv:'.$this->name.'()';
    }
  }
?>
