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
  class AAAARecord extends peer�net�Record {
   
    /**
     * (Insert method's description here)
     *
     * @param   
     * @param   
     */
    public function __construct($name, $address) {
      parent::__construct($name);
      $this->address= $address;
    }

    public function getAddress() {
      return new Inet6Address($this->address);
    }
  }
?>
