<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * An XML event triggered by a read
   *
   */
  abstract class XmlEvent extends Object {

    /**
     * Returns this event's type
     *
     * @return  xml.streams.XmlEventType
     */
    public abstract function type();
    
  }
?>
