<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Record', 'peer.net.Inet6Address');

  /**
   * AAAA record
   *
   */
  class AAAARecord extends peer·net·Record {
    protected $address = NULL;
   
    /**
     * Creates a new record
     *
     * @param   string name
     * @param   var address
     */
    public function __construct($name, $address) {
      parent::__construct($name);
      $this->address= $address instanceof Inet6Address ? $address : new Inet6Address($address);
    }

    /**
     * Gets an IPV6 address
     *
     * @return  peer.net.Inet6Address
     */
    public function getAddress() {
      return $this->address;
    }

    /**
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->address->toString().')';
    }
  }
?>
