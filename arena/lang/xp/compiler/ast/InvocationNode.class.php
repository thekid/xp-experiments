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
    public 
      $chained    = NULL,
      $parameters = array();
      
    
    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      $s= $this->name.'()';
      $c= $this->chained;
      while (NULL !== $c) {
        $s.= '.'.$c->hashCode();
        $c= $c->chained;
      }
      return $s;
    }
  }
?>
