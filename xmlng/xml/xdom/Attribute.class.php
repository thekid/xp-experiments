<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.xdom.XMLNamespace');

  /**
   * (Insert class' description here)
   *
   */
  class Attribute extends Object {
    protected $name= NULL;
    protected $value= NULL;
    protected $ns= NULL;
    
    /**
     * Constructor
     *
     * @param   string name
     * @param   string value
     * @param   xml.xdom.XMLNamespace ns
     */
    public function __construct($name, $value, XMLNamespace $ns= NULL) {
      $this->name= $name;
      $this->value= $value;
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
     * @return  string
     */
    public function getValue() {
      return $this->value;
    }

    /**
     * (Insert method's description here)
     *
     * @param   string value
     */
    public function setValue($value) {
      $this->value= $value;
    }

    /**
     * (Insert method's description here)
     *
     * @return  xml.xdom.XMLNamespace
     */
    public function getNamespace() {
      return $this->ns;
    }
  }
?>
