<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses('lang.Generic');
 
  /**
   * Class Object is the root of the class hierarchy. Every class has 
   * Object as a superclass. 
   *
   * @purpose  Base class for all others
   */
  class Object implements Generic {
    public $__id;
    
    /**
     * Cloning handler
     *
     */
    public function __clone() {
      if (!$this->__id) $this->__id= microtime();
      $this->__id= microtime();
    }

    /**
     * Method handler
     *
     */
    public function __call($name, $args) {
      $class= get_class($this);
      do {
        if (isset(xp::$registry[$m= $class.'::'.$name])) {
          return xp::$registry[$m]->invokeArgs(NULL, array_merge(array($this), $args));
        }
      } while ($class= get_parent_class($class));
      $c= new ReflectionClass($this);
      foreach ($c->getInterfaceNames() as $i) {
        if (isset(xp::$registry[$m= $i.'::'.$name])) {
          return xp::$registry[$m]->invokeArgs(NULL, array_merge(array($this), $args));
        }
      }
      throw new Error('Call to undefined method '.$c->getName().'::'.$name);
    }

    /**
     * Returns a hashcode for this object
     *
     * @return  string
     */
    public function hashCode() {
      if (!$this->__id) $this->__id= microtime();
      return $this->__id;
    }
    
    /**
     * Indicates whether some other object is "equal to" this one.
     *
     * @param   lang.Object cmp
     * @return  bool TRUE if the compared object is equal to this object
     */
    public function equals($cmp) {
      if (!$this->__id) $this->__id= microtime();
      if (!$cmp->__id) $cmp->__id= microtime();
      return $this === $cmp;
    }
    
    /** 
     * Returns the fully qualified class name for this class 
     * (e.g. "io.File")
     * 
     * @return  string fully qualified class name
     */
    public function getClassName() {
      return xp::nameOf(get_class($this));
    }

    /**
     * Returns the runtime class of an object.
     *
     * @return  lang.XPClass runtime class
     * @see     xp://lang.XPClass
     */
    public function getClass() {
      return new XPClass($this);
    }

    /**
     * Creates a string representation of this object. In general, the toString 
     * method returns a string that "textually represents" this object. The result 
     * should be a concise but informative representation that is easy for a 
     * person to read. It is recommended that all subclasses override this method.
     * 
     * Per default, this method returns:
     * <xmp>
     *   [fully-qualified-class-name] '{' [members-and-value-list] '}'
     * </xmp>
     * 
     * Example:
     * <xmp>
     *   lang.Object {
     *     __id => "0.43080500 1158148350"
     *   }
     * </xmp>
     *
     * @return  string
     */
    public function toString() {
      if (!$this->__id) $this->__id= microtime();
      return xp::stringOf($this);
    }
  }
?>
