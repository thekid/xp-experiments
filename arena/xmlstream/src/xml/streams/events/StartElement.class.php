<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.streams.XmlEvent');

  /**
   * Represents the START_ELEMENT event
   *
   */
  class StartElement extends XmlEvent {
    protected $name= '';
    protected $attributes= array();
    
    /**
     * Constructor
     *
     * @param   string name
     * @param   array<string, string> attributes
     */
    public function __construct($name, $attributes= array()) {
      $this->name= $name;
      $this->attributes= $attributes;
    }
    
    /**
     * Returns this event's type
     *
     * @return  xml.streams.XmlEventType
     */
    public function type() {
      return XmlEventType::$START_ELEMENT;
    }
    
    /**
     * Returns whether another object is equal to this XML event
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return (
        $cmp instanceof self && 
        $cmp->name === $this->name && 
        $cmp->attributes == $this->attributes
      );
    }
  }
?>
