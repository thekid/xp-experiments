<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /*static*/ class _Method extends Object {
    protected $reflect;

    public function __construct($reflect) {
      $this->reflect= $reflect;
    }
    
    public function name() {
      return $this->reflect->getName();
    }
  }
  
  /*static*/ class _MethodList extends ArrayObject {
    public function __construct($a) {
      parent::__construct($a);
      $this->setIteratorClass('_MethodIterator');
    }

    public function offsetGet($offset) {
      return new _Method(parent::offsetGet($offset));
    }
  }
  
  /*static*/ class _MethodIterator extends ArrayIterator {
    public function current() {
      return new _Method(parent::current());
    }
  }
  
  /*static*/ class _Methods implements Iterator {
    public $elements, $offset, $size;
    
    public function __construct($elements) {
      $this->elements= $elements;
      $this->offset= 0;
      $this->size= sizeof($elements);
    }
    
    public function rewind() {
      $this->offset= 0;
    }
    
    public function next() {
      $this->offset++;
    }
    
    public function valid() {
      return $this->offset < $this->size;   
    }
    
    public function key() {
      return $this->offset;
    }

    public function current() {
      return new _Method($this->elements[$this->offset]);
    }
  }

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
        $r[]= new _Method($method);
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
     * Get class methods
     *
     * @return  ArrayObject<ReflectionMethod>
     */
    public function listMethods() {
      return new _MethodList($this->reflect->getMethods());
    } 

    /**
     * Get class methods - cached
     *
     * @return  ArrayObject<ReflectionMethod>
     */
    public function listMethodsCached() {
      if (!isset($this->cache[1])) {
        $this->cache[1]= $this->listMethods();
      }
      return $this->cache[1];
    } 

    /**
     * Get iterator for class methods
     *
     * @return  Iterator<ReflectionMethod>
     */
    public function methodIterator() {
      return new _MethodIterator($this->reflect->getMethods());
    } 

    /**
     * Get iterator for class methods - cached
     *
     * @return  Iterator<ReflectionMethod>
     */
    public function methodIteratorCached() {
      if (!isset($this->cache[2])) {
        $this->cache[2]= $this->methodIterator();
      }
      return $this->cache[2];
    } 

    /**
     * Get object for class methods
     *
     * @return  _Methods
     */
    public function methods() {
      return new _Methods($this->reflect->getMethods());
    } 

    /**
     * Get object for class methods - cached
     *
     * @return  _Methods
     */
    public function methodsCached() {
      if (!isset($this->cache[3])) {
        $this->cache[3]= $this->methods();
      }
      return $this->cache[3];
    } 
  }
?>
