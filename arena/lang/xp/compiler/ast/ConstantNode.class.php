<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.ConstantValueNode');

  /**
   * (Insert class' description here)
   *
   * @purpose  purpose
   */
  class ConstantNode extends ConstantValueNode {

    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      return 'xp.const:'.xp::stringOf($this->value);
    }
  }
?>
