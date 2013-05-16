<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.streams.XmlEvent');

  /**
   * Represents the DOCTYPE event
   *
   */
  abstract class DocType extends XmlEvent {
    protected $name= '';
    
    /**
     * Constructor
     *
     * @param   string name
     */
    public function __construct($name) {
      $this->name= $name;
    }
   
    /**
     * Returns this event's type
     *
     * @return  xml.streams.XmlEventType
     */
    public function type() {
      return XmlEventType::$DOCTYPE;
    }
  }
?>
