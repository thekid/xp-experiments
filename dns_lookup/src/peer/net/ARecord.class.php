<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Record', 'peer.net.Inet4Address');

  /**
   * A record
   *
   */
  class ARecord extends peer·net·Record {
    protected $address;
    
    /**
     * Creates a new record
     *
     * @param   string name
     * @param   string address
     */
    public function __construct($name, $address) {
      parent::__construct($name);
      $this->address= $address;
    }
    
    /**
     * Gets an IPV4 address
     *
     * @return  peer.net.Inet4Address
     */
    public function getAddress() {
      return new Inet4Address($this->address);
    }

    /**
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->address.')';
    }
  }
?>
