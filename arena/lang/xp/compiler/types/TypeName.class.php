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
    
    public static $primitives = array('int', 'double', 'bool', 'string');
    public static $VAR;
    
    static function __static() {
      self::$VAR= new self('var');
    }
    
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
    public function isClass() {
      return !$this->isArray() && !$this->isMap() && !$this->isVariable() && !$this->isVoid() && !$this->isPrimitive();
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
     * Return whether this type is a generic
     *
     * @return  bool
     */
    public function isGeneric() {
      return !empty($this->components);
    }

    /**
     * Checks whether another object is equal to this type name
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      if (!$cmp instanceof self || $this->name !== $cmp->name) return FALSE;

      foreach ($this->components as $i => $c) {
        if (!$c->equals($cmp->components[$i])) return FALSE;
      }
      return TRUE;
    }
    
    /**
     * Helper for compoundName() and toString()
     *
     * @return  string
     */
    protected function compoundNameOf(self $type) {
      if (!$type->components) return $type->name;

      $s= $type->name.'<';
      foreach ($type->components as $c) {
        $s.= $this->compoundNameOf($c).', ';
      }
      return substr($s, 0, -2).'>';
    }
    
    /**
     * Returns a compound type name
     *
     * @return  string
     */
    public function compoundName() {
      return $this->compoundNameOf($this);
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->compoundNameOf($this).')';
    }
  }
?>
