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
  class ClassMemberNode extends xp·compiler·ast·Node {
    
    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      $s= $this->class->name.'::'.$this->member->hashCode();
      $c= $this->chained;
      while (NULL !== $c) {
        $s.= '.'.$c->hashCode();
        $c= $c->chained;
      }
      return $s;
    }
  }
?>
