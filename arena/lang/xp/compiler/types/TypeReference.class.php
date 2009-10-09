<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.types.Types');

  /**
   * (Insert class' description here)
   *
   */
  class TypeReference extends Types {
    protected $type= NULL;
    
    /**
     * Constructor
     *
     * @param   xp.compiler.types.TypeName
     * @param   int kind
     */
    public function __construct(TypeName $type, $kind= parent::CLASS_KIND) {
      $this->type= $type;
      $this->kind= $kind;
    }

    /**
     * Returns parent type
     *
     * @return  xp.compiler.types.Types
     */
    public function parent() {
      return NULL;
    }
    
    /**
     * Returns name
     *
     * @return  string
     */
    public function name() {
      return $this->type->name;
    }

    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public function literal() {
      return $this->type->name;
    }

    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public function kind() {
      return $this->kind;
    }

    /**
     * Returns whether this type is enumerable (that is: usable in foreach)
     *
     * @return  bool
     */
    public function isEnumerable() {
      return $this->type->isArray() || $this->type->isMap();
    }

    /**
     * Returns whether a constructor exists
     *
     * @return  bool
     */
    public function hasConstructor() {
      return TRUE;
    }

    /**
     * Returns the constructor
     *
     * @return  xp.compiler.types.Constructor
     */
    public function getConstructor() {
      $c= new xp·compiler·types·Constructor();
      $c->parameters= array();
      $c->holder= $this;
      return $c;
    }

    /**
     * Returns a method by a given name
     *
     * @param   string name
     * @return  bool
     */
    public function hasMethod($name) {
      return TRUE;
    }
    
    /**
     * Returns a method by a given name
     *
     * @param   string name
     * @return  xp.compiler.types.Method
     */
    public function getMethod($name) {
      $m= new xp·compiler·types·Method();
      $m->name= $name;
      $m->returns= new TypeName('var');
      $m->parameters= array();
      $m->holder= $this;
      return $m;
    }

    /**
     * Returns a field by a given name
     *
     * @param   string name
     * @return  bool
     */
    public function hasField($name) {
      return TRUE;
    }
    
    /**
     * Returns a field by a given name
     *
     * @param   string name
     * @return  xp.compiler.types.Field
     */
    public function getField($name) {
      $m= new xp·compiler·types·Field();
      $m->name= $name;
      $m->type= new TypeName('var');
      $m->holder= $this;
      return $m;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */    
    public function toString() {
      return $this->getClassName().'@(*->'.$this->name.')';
    }
  }
?>
