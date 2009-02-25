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
  class StringNode extends ConstantValueNode {

    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      return 'xp.string:'.$this->value;
    }
  }
?>
