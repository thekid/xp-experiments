<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */


  uses('xml.xdom.Element', 'lang.IndexOutOfBoundsException');
  
  /**
   * (Insert class' description here)
   *
   * @see      xp://xml.xdom.Element
   */
  class ElementList extends Object {
    protected $backing= array();
    protected $parent= NULL;
    protected $size= 0;

    /**
     * (Insert method's description here)
     *
     * @param   xml.xdom.Element parent
     */
    public function __construct(Element $parent) {
      $this->parent= $parent;
    }

    /**
     * Returns the number of elements in this list.
     *
     * @return  int
     */
    public function size() {
      return $this->size;
    }
    
    /**
     * Tests if this list has no elements.
     *
     * @return  bool
     */
    public function isEmpty() {
      return 0 === $this->size;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   xml.xdom.Element e
     * @return  xml.xdom.Element e
     */
    public function add(Element $e) {
      $this->backing[]= $e;
      $e->setParent($this->parent);
      $this->size++;
      return $e;
    }

    /**
     * (Insert method's description here)
     *
     * @param   int i
     * @param   xml.xdom.Element e
     * @return  xml.xdom.Element e
     */
    public function insert($i, Element $e) {
      if ($i < 0 || $i >= $this->size) {
        throw new IndexOutOfBoundsException('No child at offset '.$i);
      }
      $this->backing= array_merge(
        array_slice($this->backing, 0, $i),
        array($e),
        array_slice($this->backing, $i)
      );
      $e->setParent($this->parent);
      $this->size++;
      return $e;
    }

    /**
     * (Insert method's description here)
     *
     * @param   int i
     * @param   xml.xdom.Element e
     * @return  xml.xdom.Element e
     */
    public function set($i, Element $e) {
      if ($i < 0 || $i >= $this->size) {
        throw new IndexOutOfBoundsException('No child at offset '.$i);
      }
      $this->backing[$i]= $e;
      $e->setParent($this->parent);
      return $e;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   int i
     * @return  xml.xdom.Element e
     */
    public function get($i) {
      if ($i < 0 || $i >= $this->size) {
        throw new IndexOutOfBoundsException('No child at offset '.$i);
      }
      return $this->backing[$i];
    }

    /**
     * (Insert method's description here)
     *
     * @param   int i
     */
    public function remove($i) {
      if ($i < 0 || $i >= $this->size) {
        throw new IndexOutOfBoundsException('No child at offset '.$i);
      }
      $this->backing= array_merge(
        array_slice($this->backing, 0, $i),
        array_slice($this->backing, $i+ 1)
      );
      $this->size--;
    }

    /**
     * (Insert method's description here)
     *
     */
    public function clear() {
      $this->backing= array();
      $this->size= 0;
    }
    
    /**
     * (Insert method's description here)
     *
     * @return  string
     */
    public function toString() {
      $s= $this->getClassName().'['.$this->size."] {\n";
      foreach ($this->backing as $index => $element) {
        $s.= '  '.$index.' => '.xp::stringOf($element)."\n";
      }
      return $s.'}';
    }
  }
?>
