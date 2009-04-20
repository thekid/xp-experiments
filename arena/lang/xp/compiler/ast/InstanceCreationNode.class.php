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
    public 
      $chained    = NULL;
    
    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      $s= 'new '.$this->type->name;
      $c= $this->chained;
      while (NULL !== $c) {
        $s.= '.'.$c->hashCode();
        $c= $c->chained;
      }
      return $s;
    }
  }
?>
