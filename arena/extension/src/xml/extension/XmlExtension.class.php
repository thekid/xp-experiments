<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.Node');

  /**
   * XML extension methods
   *
   */
  class XmlExtension extends Object {
    
    static function __static() {
      xp::extensions('lang.Generic', __CLASS__);
    }
    
    /**
     * Creates a node from any object
     *
     * @param   lang.Generic self
     * @param   string name
     * @return  xml.Node
     */
    public static function asNode(Generic $self, $name) {
      return Node::fromObject($self, $name);
    }
  }
?>
