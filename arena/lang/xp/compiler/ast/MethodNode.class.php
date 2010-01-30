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
      $name       = '',
      $modifiers  = 0,
      $returns    = NULL,
      $parameters = array();

    /**
     * Returns this routine's name
     *
     * @return  string
     */
    public function getName() {
      return $this->name;
    }
      
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
