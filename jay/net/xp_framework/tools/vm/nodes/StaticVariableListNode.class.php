<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('net.xp_framework.tools.vm.VNode');

  /**
   * StaticVariableList
   *
   * @see   xp://net.xp_framework.tools.vm.nodes.VNode
   */ 
  class StaticVariableListNode extends VNode {
    public
      $list = array();
      
    /**
     * Constructor
     *
     * @param   mixed list
     */
    public function __construct($list) {
      $this->list= $list;
    }  
  }
?>
