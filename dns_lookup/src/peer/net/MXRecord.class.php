<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Record');

  /**
   * (Insert class' description here)
   *
   */
  class MXRecord extends peer·net·Record {
   
    /**
     * (Insert method's description here)
     *
     * @param   
     * @param   
     */
    public function __construct($name, $priority, $target) {
      parent::__construct($name);
      $this->priority= $priority;
      $this->target= $target;
    }

    public function getTarget() {
      return $this->target;
    }
  }
?>
