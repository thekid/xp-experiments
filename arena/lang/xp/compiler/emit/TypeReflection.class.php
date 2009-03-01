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
  }
?>
