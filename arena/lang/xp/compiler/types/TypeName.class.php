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
     * Return whether this type is an array type
     *
     * @return  bool
     */
    public function isArray() {
      return '[]' == substr($this->name, -2);
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
     * Returns a compound type name
     *
     * @return  string
     */
    protected function compoundTypeName(self $type) {
      if (!$type->components) return $type->name;

      $s= $type->name.'<';
      foreach ($type->components as $c) {
        $s.= $this->compoundTypeName($c).', ';
      }
      return substr($s, 0, -2).'>';
    }
    
    /**
     * (Insert method's description here)
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->compoundTypeName($this).')';
    }
  }
?>
