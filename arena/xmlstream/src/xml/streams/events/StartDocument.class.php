<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.streams.XmlEvent');

  /**
   * Represents the START_DOCUMENT event
   *
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
  }
?>
