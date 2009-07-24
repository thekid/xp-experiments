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
    
    /**
     * (Insert method's description here)
     *
     * @param   string name
     */
    public function __construct($name) {
      $this->name= $name;
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
     * (Insert method's description here)
     *
     * @param   string name
     * @return  xml.xdom.ElementList
     */
    public function childrenNamed($name) {
      return $this->children;
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
