<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net.dns';

  uses('peer.net.dns.Record', 'peer.net.dns.QType');

  /**
   * Query record
   *
   */
  class peer·net·dns·Query extends peer·net·dns·Record {
    protected $qtype = NULL;
    protected $qclass = 0;
   
    /**
     * Creates a new record
     *
     * @param   string name
     * @param   peer.net.dns.QType qtype
     * @param   peer.net.dns.QClass qclass
     */
    public function __construct($name, $qtype, $qclass) {
      parent::__construct($name, 0);
      $this->qtype= $qtype;
      $this->qclass= $qclass;
    }

    /**
     * Gets qtype
     *
     * @return  peer.net.dns.QType
     */
    public function getQType() {
      return $this->qtype;
    }

    /**
     * Gets qclass
     *
     * @return  peer.net.dns.QClass
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
      return sprintf(
        '%s("%s" #%d:%s #%d:%s)',
        $this->getClassName(),
        $this->name,
        $this->qtype->ordinal(),
        $this->qtype->name(),
        $this->qclass->ordinal(),
        $this->qclass->name()
      );
    }
  }
?>
