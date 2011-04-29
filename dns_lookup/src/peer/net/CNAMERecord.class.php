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
  class CNAMERecord extends peer·net·Record {
   
    /**
     * (Insert method's description here)
     *
     * @param   
     * @param   
     */
    public function __construct($name, $target) {
      parent::__construct($name);
      $this->target= $target;
    }

    public function getTarget() {
      return $this->target;
    }
  }
?>
