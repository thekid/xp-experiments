<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.RoutineNode');

  /**
   * (Insert class' description here)
   *
   * @purpose  purpose
   */
  class OperatorNode extends RoutineNode {

    /**
     * Returns this routine's name
     *
     * @return  string
     */
    public function getName() {
      return 'operator'.$this->symbol;
    }
  }
?>
