<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @purpose  Value object
   */
  class TypeName extends Object {
    public
      $name       = '',
      $components = array();   
    
    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @param   xp.compiler.types.TypeName[] components
     */
    public function __construct($name, $components= array()) {
      $this->name= $name;
      $this->components= $components;
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function equals($cmp) {
      if (!$cmp instanceof self || $this->name !== $cmp->name) return FALSE;

      foreach ($this->components as $i => $c) {
        if (!$c->equals($cmp->components[$i])) return FALSE;
      }
      return TRUE;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function toString() {
      if (!$this->components) {
        return $this->getClassName().'('.$this->name.')';
      }
      $s= $this->getClassName().'('.$this->name.'<';
      foreach ($this->components as $c) {
        $s.= $c->name.', ';
      }
      return substr($s, 0, -2).'>)';
    }
  }
?>
