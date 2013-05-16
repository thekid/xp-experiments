<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.streams.XmlEvent');

  /**
   * Represents the CDATA event
   *
   */
  class CData extends XmlEvent {
    protected $text= '';
    
    /**
     * Constructor
     *
     * @param   string text
     */
    public function __construct($text) {
      $this->text= $text;
    }
    
    /**
     * Returns this event's type
     *
     * @return  xml.streams.XmlEventType
     */
    public function type() {
      return XmlEventType::$CDATA;
    }
    
    /**
     * Returns whether another object is equal to this XML event
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return $cmp instanceof self && $cmp->text === $this->text;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'("'.$this->text.'")';
    }
  }
?>
