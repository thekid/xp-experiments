<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.xdom.Element', 'xml.xdom.ElementList');

  /**
   * (Insert class' description here)
   *
   */
  class Node extends Element {
    protected $name= '';
    protected $children= NULL;
    protected $attributes= array();
    
    /**
     * (Insert method's description here)
     *
     * @param   string name
     */
    public function __construct($name, array $attributes= array()) {
      $this->name= $name;
      $this->attributes= $attributes;
      $this->children= new ElementList($this);
    }
    
    /**
     * (Insert method's description here)
     *
     * @return  string
     */
    public function getName() {
      return $this->name;
    }
    
    /**
     * (Insert method's description here)
     *
     * @return  xml.xdom.ElementList
     */
    public function children() {
      return $this->children;
    }
    
    /**
     * Add a child
     *
     * @param   xml.xdom.Element e
     * @return  xml.xdom.Element
     */
    public function addChild(Element $e) {
      return $this->children->add($e);
    }

    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @return  string
     */
    public function getAttribute($name) {
      if (!isset($this->attributes[$name])) {
        throw new IllegalArgumentException('No such attribute '.$name);
      }
      return $this->attributes[$name];
    }

    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @return  bool
     */
    public function hasAttribute($name) {
      return isset($this->attributes[$name]);
    }

    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @param   string value
     */
    public function setAttribute($name, $value) {
      $this->attributes[$name]= (string)$value;
    }

    /**
     * (Insert method's description here)
     *
     * @param   string name
     */
    public function removeAttribute($name) {
      if (!isset($this->attributes[$name])) {
        throw new IllegalArgumentException('No such attribute '.$name);
      }
      unset($this->attributes[$name]);
    }

    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @param   string value
     * @return  xml.xdom.Node
     */
    public function withAttribute($name, $value) {
      $this->attributes[$name]= (string)$value;
      return $this;
    }

    /**
     * (Insert method's description here)
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'['.$this->name.']';
    }
  }
?>
