<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.xdom.Element', 'xml.xdom.ElementList', 'xml.xdom.Attribute');

  /**
   * (Insert class' description here)
   *
   */
  class Node extends Element {
    protected $name= '';
    protected $children= NULL;
    protected $attributes= array();
    protected $ns= NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @param   array<string, string> attributes
     * @param   xml.xdom.XMLNamespace ns
     */
    public function __construct($name, array $attributes= array(), XMLNamespace $ns= NULL) {
      $this->name= $name;
      $this->children= new ElementList($this);
      foreach ($attributes as $key => $value) {
        $this->attributes[$key]= new Attribute($key, $value);
      }
      $this->ns= $ns;
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
     * Set parent element
     *
     * @param   xml.xdom.Element parent
     */
    public function setParent(Element $parent) {
      parent::setParent($parent);
      if (!$this->ns) $this->ns= $parent->ns;   // Inherit parent's namespace
    }

    /**
     * (Insert method's description here)
     *
     * @return  string
     */
    public function qualifiedName() {
      return NULL === $this->ns ? $this->name : $this->ns->qualify($this->name);
    }

    /**
     * (Insert method's description here)
     *
     * @return  xml.xdom.XMLNamespace
     */
    public function getNamespace() {
      return $this->ns;
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
     * @param   xml.xdom.XMLNamespace ns
     * @return  xml.xdom.Attribute
     */
    public function getAttribute($name, XMLNamespace $ns= NULL) {
      $q= $ns ? $ns->qualify($name) : $name;
      if (!isset($this->attributes[$q])) {
        throw new IllegalArgumentException('No such attribute '.$q);
      }
      return $this->attributes[$q];
    }

    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @param   xml.xdom.XMLNamespace ns
     * @return  bool
     */
    public function hasAttribute($name, XMLNamespace $ns= NULL) {
      return isset($this->attributes[$ns ? $ns->qualify($name) : $name]);
    }

    /**
     * (Insert method's description here)
     *
     * @param   string key
     * @param   string value
     */
    public function setAttribute($key, $value= NULL) {
      if ($key instanceof Attribute) {
        $this->attributes[$key->qualifiedName()]= $key;
      } else if (!isset($this->attributes[$key])) {
        $this->attributes[$key]= new Attribute($key, $value);
      } else {
        $this->attributes[$key]->setValue($value);
      }
    }

    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @param   xml.xdom.XMLNamespace ns
     */
    public function removeAttribute($name, XMLNamespace $ns= NULL) {
      $q= $ns ? $ns->qualify($name) : $name;
      if (!isset($this->attributes[$q])) {
        throw new IllegalArgumentException('No such attribute '.$q);
      }
      unset($this->attributes[$q]);
    }

    /**
     * (Insert method's description here)
     *
     * @param   string key
     * @param   string value
     * @return  xml.xdom.Node
     */
    public function withAttribute($key, $value= NULL) {
      if ($key instanceof Attribute) {
        $this->attributes[$key->qualifiedName()]= $key;
      } else if (!isset($this->attributes[$key])) {
        $this->attributes[$key]= new Attribute($key, $value);
      } else {
        $this->attributes[$key]->setValue($value);
      }
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
