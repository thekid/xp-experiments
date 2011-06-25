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
    protected $address = NULL;
    
    /**
     * Creates a new record
     *
     * @param   string name
     * @param   int ttl
     * @param   string address
     */
    public function __construct($name, $ttl, $address) {
      parent::__construct($name, $ttl);
      $this->address= $address instanceof Inet4Address ? $address : new Inet4Address($address);
    }
    
    /**
     * Gets an IPV4 address
     *
     * @return  peer.net.Inet4Address
     */
    public function getAddress() {
      return $this->address;
    }
    
    /**
     * Returns whether a given object is equal to this record
     *
     * @param   var cmp
     * @return  bool
     */
    public function equals($cmp) {
      return (
        $cmp instanceof self && 
        $this->name === $cmp->name && 
        $this->ttl === $cmp->ttl && 
        $this->address->equals($cmp->address)
      );
    }

    /**
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->name.' ttl '.$this->ttl.' '.$this->address->toString().')';
    }
  }
?>
