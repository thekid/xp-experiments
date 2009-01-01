<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Mini XPClass
   *
   * @see      xp://Arrays
   * @see      xp://lang.XPClass
   */
  class Clazz extends Object {
    protected $reflect;
    protected $cache= array();

    /**
     * Constructor
     *
     * @param   php.ReflectionClass reflect
     */
    protected function __construct($reflect) {
      $this->reflect= $reflect;
    }

    /**
     * Return a clazz instance for a given class' name
     *
     * @param   string name
     * @return  Clazz instance
     */
    public static function forName($name) {
      return new self(new ReflectionClass(xp::reflect($name)));
    }
    
    /**
     * Get class methods
     *
     * @return  ReflectionMethod[]
     */
    public function getMethods() {
      $r= array();
      foreach ($this->reflect->getMethods() as $method) {
        $r[]= $method;
      }
      return $r;
    } 

    /**
     * Get class methods - cached
     *
     * @return  ReflectionMethod[]
     */
    public function getMethodsCached() {
      if (!isset($this->cache[0])) {
        $this->cache[0]= $this->getMethods();
      }
      return $this->cache[0];
    } 

    /**
     * Get iterator for class methods
     *
     * @return  Iterator<ReflectionMethod>
     */
    public function methods() {
      return new ArrayIterator($this->reflect->getMethods());
    } 

    /**
     * Get iterator for class methods - cached
     *
     * @return  Iterator<ReflectionMethod>
     */
    public function methodsCached() {
      if (!isset($this->cache[1])) {
        $this->cache[1]= $this->methods();
      }
      return $this->cache[1];
    } 
  }
?>
