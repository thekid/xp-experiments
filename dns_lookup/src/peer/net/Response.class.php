<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net';
  
  uses('peer.net.RCode');

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
     * @param   var result either an int or a peer.net.RCode instance
     * @param   peer.net.Record[] records
     */
    public function __construct($result, $records) {
      $this->result= $result instanceof RCode ? $result : RCode::withId($result);
      $this->records= $records;
    }

    /**
     * Gets result
     *
     * @return  peer.net.RCode
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
      return sprintf(
        '%s(#%d: %s)@%s',
        $this->getClassName(),
        $this->result->ordinal(),
        $this->result->name(),
        xp::stringOf($this->records)
      );
    }
  }
?>
