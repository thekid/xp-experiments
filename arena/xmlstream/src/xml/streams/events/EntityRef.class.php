<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.streams.XmlEvent');

  /**
   * Represents the ENTITY_REF event
   *
   */
  class EntityRef extends XmlEvent {
    protected $entity= '';
    
    /**
     * Constructor
     *
     * @param   string entity
     */
    public function __construct($entity) {
      $this->entity= $entity;
    }
    
    /**
     * Returns this event's type
     *
     * @return  xml.streams.XmlEventType
     */
    public function type() {
      return XmlEventType::$ENTITY_REF;
    }
    
    /**
     * Returns whether another object is equal to this XML event
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return $cmp instanceof self && $cmp->entity === $this->entity;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->entity.')';
    }
  }
?>
