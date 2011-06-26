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
   * @test  xp://net.xp_framework.unittest.peer.net.ResponseTest
   * @see   xp://peer.net.DnsLookup#run
   */
  class peer·net·Response extends Object {
    protected $result= -1;
    protected $records= array();
    
    /**
     * Create a new instance
     *
     * @param   var result either an int or a peer.net.RCode instance
     * @param   peer.net.Record[][] records
     */
    public function __construct($result, $records) {
      $this->result= $result instanceof RCode ? $result : RCode::withId($result);
      for ($i= 0; $i < 4; $i++) {   // 4 sections
        $this->records[$i]= isset($records[$i]) ? $records[$i] : array();
      }
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
     * @return  peer.net.Record[][]
     */
    public function records() {
      return $this->records;
    }

    /**
     * Gets all question records
     *
     * @return  peer.net.Record[]
     */
    public function questions() {
      return $this->records[Sections::QUESTION];
    }

    /**
     * Gets all answer records
     *
     * @return  peer.net.Record[]
     */
    public function answers() {
      return $this->records[Sections::ANSWER];
    }

    /**
     * Gets all authority records
     *
     * @return  peer.net.Record[]
     */
    public function authorities() {
      return $this->records[Sections::AUTHORITY];
    }

    /**
     * Gets all additional records
     *
     * @return  peer.net.Record[]
     */
    public function additional() {
      return $this->records[Sections::ADDITIONAL];
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        "%s(#%d: %s)@{\n".
        "  [QUESTION  ] %s\n".
        "  [ANSWER    ] %s\n".
        "  [AUTHORITY ] %s\n".
        "  [ADDITIONAL] %s\n".
        "}",
        $this->getClassName(),
        $this->result->ordinal(),
        $this->result->name(),
        str_replace("\n", "\n  ", xp::stringOf($this->records[Sections::QUESTION])),
        str_replace("\n", "\n  ", xp::stringOf($this->records[Sections::ANSWER])),
        str_replace("\n", "\n  ", xp::stringOf($this->records[Sections::AUTHORITY])),
        str_replace("\n", "\n  ", xp::stringOf($this->records[Sections::ADDITIONAL]))
      );
    }
  }
?>
