<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.streams.XmlEvent');

  /**
   * Represents the PROCESSING_INSTRUCTION event
   *
   */
  class ProcessingInstruction extends XmlEvent {
    protected $target= '';
    protected $data= '';
    
    /**
     * Constructor
     *
     * @param   string target
     * @param   string data
     */
    public function __construct($target, $data) {
      $this->target= $target;
      $this->data= $data;
    }
    
    /**
     * Returns this event's type
     *
     * @return  xml.streams.XmlEventType
     */
    public function type() {
      return XmlEventType::$PROCESSING_INSTRUCTION;
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
        $cmp->target === $this->target &&
        $cmp->data === $this->data
      );
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->target.'>@{'.$this->text.'}';
    }
  }
?>
