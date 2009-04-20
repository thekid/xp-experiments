<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.emit.Types');

  /**
   * (Insert class' description here)
   *
   */
  class TypeReflection extends Types {
    protected $class= NULL;
    
    /**
     * Constructor
     *
     * @param   lang.XPClass class
     */
    public function __construct(XPClass $class) {
      $this->class= $class;
    }
    
    /**
     * Returns name
     *
     * @return  string
     */
    public function name() {
      return $this->class->getName();
    }

    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public function literal() {
      return $this->class->getSimpleName();
    }
    
    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public function kind() {
      if ($this->class->isInterface()) {
        return parent::INTERFACE_KIND;
      } else if ($this->class->isEnum()) {
        return parent::ENUM_KIND;
      } else {
        return parent::CLASS_KIND;
      }
    }

    /**
     * Creates a xp.compiler.emit.Method object from a given
     * lang.reflect.Method instance.
     *
     * @param   lang.reflect.Method method
     * @return  xp.compiler.emit.Method
     */
    protected function method(Method $method) {
      $t= $method->getReturnTypeName();
      
      // Correct old usages of the return type name
      if ('mixed' === $t || '*' === $t || NULL === $t || 'resource' === $t) {
        $t= 'var';
      }

      $m= new xp·compiler·emit·Method();
      $m->name= $method->getName();
      $m->returns= new TypeName($t);
      $m->modifiers= $method->getModifiers();
      $m->parameters= array();
      foreach ($method->getParameters() as $p) {
        $m->parameters[]= $p->getTypeName();
      }
      $m->holder= $this;
      return $m;
    }

    /**
     * Returns a method by a given name
     *
     * @param   string name
     * @return  bool
     */
    public function hasMethod($name) {
      return $this->class->hasMethod($name);
    }
    
    /**
     * Returns a method by a given name
     *
     * @param   string name
     * @return  xp.compiler.emit.Method
     */
    public function getMethod($name) {
      return $this->method($this->class->getMethod($name));
    }

    /**
     * Creates a xp.compiler.emit.Field object from a given
     * lang.reflect.Field instance.
     *
     * @param   lang.reflect.Field field
     * @return  xp.compiler.emit.Field
     */
    protected function field(Field $field) {
      $t= $field->getType();

      // Correct old usages of the return type name
      if ('mixed' === $t || '*' === $t || NULL === $t) {
        $t= 'var';
      }

      $m= new xp·compiler·emit·Field();
      $m->name= $field->getName();
      $m->type= new TypeName($t);
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
      return $this->class->hasField($name);
    }
    
    /**
     * Returns a field by a given name
     *
     * @param   string name
     * @return  xp.compiler.emit.Field
     */
    public function getField($name) {
      return $this->field($this->class->getField($name));
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */    
    public function toString() {
      return $this->getClassName().'@('.$this->class->toString().')';
    }
  }
?>
