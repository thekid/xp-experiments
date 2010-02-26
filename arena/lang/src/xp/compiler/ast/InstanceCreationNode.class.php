<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.Node');

  /**
   * (Insert class' description here)
   *
   * @purpose  purpose
   */
  class InstanceCreationNode extends xp·compiler·ast·Node {
    
    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      return 'new '.$this->type->name;
    }
  }
?>
