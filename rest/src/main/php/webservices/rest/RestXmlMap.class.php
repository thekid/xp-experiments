<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.Tree');

  /**
   * Wraps an xml.Tree into an array-acessible form
   *
   */
  class RestXmlMap extends Tree implements IteratorAggregate, ArrayAccess {
    protected static $iterate= NULL;

    static function __static() {
      self::$iterate= newinstance('Iterator', array(), '{
        private $i= 0, $c;
        public function on($c) { $self= new self(); $self->c= $c; return $self; }
        public function current() { return $this->c[$this->i]->getContent(); }
        public function key() { return $this->c[$this->i]->name; }
        public function next() { $this->i++; }
        public function rewind() { $this->i= 0; }
        public function valid() { return $this->i < sizeof($this->c); }
      }');
    }
    
    /**
     * Returns an iterator for use in foreach()
     *
     * @see     php://language.oop5.iterations
     * @return  php.Iterator
     */
    public function getIterator() {
      return self::$iterate->on($this->root->children);
    }

    /**
     * = list[] overloading
     *
     * @param   string offset
     * @return  var
     */
    public function offsetGet($offset) {
      foreach ($this->root->children as $child) {
        if ($child->name === $offset) return $child->getContent();
      }
      return NULL;
    }

    /**
     * list[]= overloading
     *
     * @param   string offset
     * @param   var value
     */
    public function offsetSet($offset, $value) {
      throw new IllegalAccessException('Read-only');
    }

    /**
     * isset() overloading
     *
     * @param   int offset
     * @return  bool
     */
    public function offsetExists($offset) {
      foreach ($this->root->children as $child) {
        if ($child->name === $offset) return TRUE;
      }
      return FALSE;
    }

    /**
     * unset() overloading
     *
     * @param   int offset
     */
    public function offsetUnset($offset) {
      throw new IllegalAccessException('Read-only');
    }
  }
?>
