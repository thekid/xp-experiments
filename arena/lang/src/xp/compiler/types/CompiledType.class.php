<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.types.Types');

  /**
   * Represents a compiled type
   *
   */
  class CompiledType extends Types {
    public $methods= array();
    public $fields= array();
    public $operators= array();
    public $constants= array();
    public $properties= array();
    
    /**
     * Returns parent type
     *
     * @return  xp.compiler.types.Types
     */
    public function parent() {
      return $this->parent;
    }
    
    /**
     * Returns name
     *
     * @return  string
     */
    public function name() {
      return $this->name;
    }

    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public function literal() {
      return $this->literal;
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
     * Checks whether a given type instance is a subclass of this class.
     *
     * @param   xp.compiler.types.Types
     * @return  bool
     */
    public function isSubclassOf(Types $t) {
      return FALSE; // TBI
    }

    /**
     * Returns whether this type is enumerable (that is: usable in foreach)
     *
     * @see     php://language.oop5.iterations
     * @return  bool
     */
    public function isEnumerable() {
      return FALSE; // TBI
    }

    /**
     * Returns the enumerator for this class or NULL if none exists.
     *
     * @see     php://language.oop5.iterations
     * @return  xp.compiler.types.Enumerator
     */
    public function getEnumerator() {
      return NULL;  // TBI
    }
    
    /**
     * Returns whether a constructor exists
     *
     * @return  bool
     */
    public function hasConstructor() {
      return NULL !== $this->constructor;
    }
    
    /**
     * Returns the constructor
     *
     * @return  xp.compiler.types.Constructor
     */
    public function getConstructor() {
      return $this->constructor;
    }

    /**
     * Returns a method by a given name
     *
     * @param   string name
     * @return  bool
     */
    public function hasMethod($name) {
      return isset($this->methods[$name]);
    }
    
    /**
     * Returns a method by a given name
     *
     * @param   string name
     * @return  xp.compiler.types.Method
     */
    public function getMethod($name) {
      return isset($this->methods[$name]) ? $this->methods[$name] : NULL;
    }

    /**
     * Returns whether an operator by a given symbol exists
     *
     * @param   string symbol
     * @return  bool
     */
    public function hasOperator($symbol) {
      return isset($this->operators[$symbol]);
    }
    
    /**
     * Returns an operator by a given name
     *
     * @param   string symbol
     * @return  xp.compiler.types.Operator
     */
    public function getOperator($symbol) {
      return isset($this->operators[$symbol]) ? $this->operators[$symbol] : NULL;
    }

    /**
     * Returns a field by a given name
     *
     * @param   string name
     * @return  bool
     */
    public function hasField($name) {
      return isset($this->fields[$symbol]);
    }
    
    /**
     * Returns a field by a given name
     *
     * @param   string name
     * @return  xp.compiler.types.Field
     */
    public function getField($name) {
      return isset($this->fields[$symbol]) ? $this->fields[$symbol] : NULL;
    }

    /**
     * Returns a property by a given name
     *
     * @param   string name
     * @return  bool
     */
    public function hasProperty($name) {
      return isset($this->properties[$symbol]);
    }
    
    /**
     * Returns a property by a given name
     *
     * @param   string name
     * @return  xp.compiler.types.Property
     */
    public function getProperty($name) {
      return isset($this->properties[$symbol]) ? $this->properties[$symbol] : NULL;
    }

    /**
     * Returns a constant by a given name
     *
     * @param   string name
     * @return  bool
     */
    public function hasConstant($name) {
      return isset($this->constants[$symbol]); 
    }
    
    /**
     * Returns a constant by a given name
     *
     * @param   string name
     * @return  xp.compiler.types.Constant
     */
    public function getConstant($name) {
      return isset($this->constants[$symbol]) ? $this->constants[$symbol] : NULL;
    }

    /**
     * Returns whether this class has an indexer
     *
     * @return  bool
     */
    public function hasIndexer() {
      return NULL !== $this->indexer;
    }

    /**
     * Returns indexer
     *
     * @return  xp.compiler.types.Indexer
     */
    public function getIndexer() {
      return $this->indexer;
    }

    /**
     * Returns a lookup map of generic placeholders
     *
     * @return  [string:int]
     */
    public function genericPlaceholders() {
      return $this->generics;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */    
    public function toString() {
      return $this->getClassName().'@('.$this->name.')';
    }
  }
?>
