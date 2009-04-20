<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.ConstantValueNode');

  /**
   * Represents a constant
   *
   */
  class ConstantNode extends ConstantValueNode {

    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      return $this->value;
    }

    /**
     * Resolve this node's value.
     *
     * @return  var
     */
    public function resolve() {
      if (!defined($this->value)) {

        // FIXME: Lookup also in some kind of compilation context
        throw new IllegalStateException('Undefined constant '.$this->value);
      }
      return constant($this->value);
    }
  }
?>
