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
  class InvocationNode extends xp·compiler·ast·Node {
    public $name= '';
    public $parameters= array();
    
    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      return $this->name.'()';
    }
  }
?>
