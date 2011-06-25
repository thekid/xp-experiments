<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net';

  /**
   * Response to a DNS lookup
   *
   * @see   xp://peer.net.DnsLookup#run
   */
  class peer·net·Response extends Object {
    protected $result= -1;
    protected $records= array();
    
    /**
     * Create a new instance
     *
     * @param   int result
     * @param   int records
     */
    public function __construct($result, $records) {
      $this->result= $result;
      $this->records= $records;
    }

    /**
     * Gets result
     *
     * @return  int
     */
    public function result() {
      return $this->result;
    }

    /**
     * Gets all records
     *
     * @return  peer.net.Record[]
     */
    public function records() {
      return $this->records;
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->result.')'.xp::stringOf($this->records);
    }
  }
?>
