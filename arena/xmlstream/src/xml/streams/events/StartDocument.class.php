<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.streams.XmlEvent');

  /**
   * Represents the START_DOCUMENT event
   *
   * @test    xp://test.StartDocumentEventTest
   */
  class StartDocument extends XmlEvent {
    protected $attributes= array();
    
    /**
     * Constructor
     *
     * @param   array<string, string> attributes
     */
    public function __construct($attributes) {
      $this->attributes= $attributes;
    }
    
    /**
     * Return an attribute
     *
     * @param   string name
     * @param   string default
     * @return  string
     */
    public function attribute($name, $default= NULL) {
      return isset($this->attributes[$name]) ? $this->attributes[$name] : $default;
    }

    /**
     * Return all attributes
     *
     * @return  array<string, string>
     */
    public function attributes() {
      return $this->attributes;
    }
    
    /**
     * Returns this event's type
     *
     * @return  xml.streams.XmlEventType
     */
    public function type() {
      return XmlEventType::$START_DOCUMENT;
    }
    
    /**
     * Returns whether another object is equal to this XML event
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return $cmp instanceof self && $cmp->attributes == $this->attributes;
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'@'.xp::stringOf($this->attributes, '  ');
    }
  }
?>
