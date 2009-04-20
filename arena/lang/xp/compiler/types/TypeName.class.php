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
    
    public static
      $primitives = array('int', 'double', 'bool', 'string');
    
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
      return '[]' === substr($this->name, -2);
    }

    /**
     * Return array component type
     *
     * @return  bool
     */
    public function arrayComponentType() {
      return new self(substr($this->name, 0, -2));
    }

    /**
     * Return whether this type is a primitive type
     *
     * @return  bool
     */
    public function isPrimitive() {
      return in_array($this->name, self::$primitives);
    }

    /**
     * Return whether this type is a variable type
     *
     * @return  bool
     */
    public function isVariable() {
      return 'var' === $this->name;
    }

    /**
     * Return whether this type is a void type
     *
     * @return  bool
     */
    public function isVoid() {
      return 'void' === $this->name;
    }

    /**
     * Return whether this type is a map
     *
     * @return  bool
     */
    public function isMap() {
      return '[' === $this->name{0} && ']' === $this->name{strlen($this->name)- 1};
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
