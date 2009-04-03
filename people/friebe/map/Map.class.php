<?php
  class Closure {
  
    public function __construct() {
      foreach (xp::$registry['errors']['CLOSURE'] as $key => $value) {
        $this->scope[$key]= $value;
      }
    }
  }

  class Map extends Object implements ArrayAccess, IteratorAggregate {
  
    public function __construct(array $initial= array()) {
      $this->array= $initial;
    }
    
    public function offsetGet($key) {
      return $this->array[$key];
    }

    public function offsetSet($key, $value) {
      if (NULL === $key) {
        throw new IllegalArgumentException('Incorrect type NULL for index');
      }
      $this->array[$key]= $value;
    }

    public function offsetExists($key) {
      return array_key_exists($key, $this->array);
    }

    public function offsetUnset($key) {
      unset($this->array[$key]);
    }
    
    public function toString() {
      return $this->getClassName().xp::stringOf($this->array);
    }

    /**
     * Returns an iterator for use in foreach()
     *
     * @see     php://language.oop5.iterations
     * @return  php.Iterator
     */
    public function getIterator() {
      if (!$this->iterator) $this->iterator= newinstance('Iterator', array($this), '{
        private $k= NULL, $v;
        public function __construct($v) { $this->v= $v; }
        public function current() { return $this->v->array[$this->k]; }
        public function key() { return $this->k; }
        public function next() {  next($this->v->array); $this->k= key($this->v->array); }
        public function rewind() { reset($this->v->array); $this->k= key($this->v->array); }
        public function valid() { return $this->k; }
      }');
      return $this->iterator;
    }
    
    public function keys() {
      return array_key($this->array);
    }
    
    public static function main(array $args) {
      $map= new Map(array('key' => 'value'));
      var_dump($map);
      var_dump($map['key']);
      $map['color']= NULL;
      var_dump($map);
      foreach ($map as $key => $val) {
        var_dump($key, $val);
      }
      unset($map['color']);
      var_dump($map);
      var_dump($map['color']);
      var_dump(isset($map['color']), isset($map['key']));
      foreach ($map as $key => $val) {
        var_dump($key, $val);
      }
    }
  }
?>
