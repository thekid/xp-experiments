<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net';

  uses('peer.net.Record', 'peer.net.QType');

  /**
   * Query record
   *
   */
  class peer·net·Query extends peer·net·Record {
    protected $qtype = NULL;
    protected $qclass = 0;
   
    /**
     * Creates a new record
     *
     * @param   string name
     * @param   peer.net.QType qtype
     * @param   int qclass
     */
    public function __construct($name, $qtype, $qclass) {
      parent::__construct($name, 0);
      $this->qtype= $qtype;
      $this->qclass= $qclass;
    }

    /**
     * Gets qtype
     *
     * @return  peer.net.QType
     */
    public function getQType() {
      return $this->qtype;
    }

    /**
     * Gets qclass
     *
     * @return  int
     */
    public function getQClass() {
      return $this->qclass;
    }

    /**
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->name.' '.$this->qtype->toString().' / '.$this->qclass.')';
    }
  }
?>
