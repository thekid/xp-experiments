<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Record', 'util.TimeSpan');

  /**
   * SOA
   *
   */
  class SOARecord extends peer·net·Record {
    protected $mname, $rname, $serial, $refresh, $retry, $expire, $minTtl;
    
    /**
     * Creates a new NS record
     *
     * @param   string name
     * @param   string mname
     * @param   string rname
     * @param   int serial
     * @param   int refresh
     * @param   int retry
     * @param   int expire
     * @param   int minTtl
     */
    public function __construct($name, $mname, $rname, $serial, $refresh, $retry, $expire, $minTtl) {
      parent::__construct($name);
      $this->mname= $mname;
      $this->rname= $rname;
      $this->mname= $mname;
      $this->serial= $serial;
      $this->refresh= $refresh;
      $this->retry= $retry;
      $this->expire= $expire;
      $this->minTtl= $minTtl;
    }

    /**
     * Returns mname
     *
     * @return  int
     */
    public function getMname() {
      return $this->mname;
    }

    /**
     * Returns rname
     *
     * @return  string
     */
    public function getRname() {
      return $this->rname;
    }
    
    /**
     * Returns serial
     *
     * @return  int
     */
    public function getSerial() {
      return $this->serial;
    }

    /**
     * Returns refresh
     *
     * @return  util.TimeSpan
     */
    public function getRefresh() {
      return new TimeSpan($this->refresh);
    }

    /**
     * Returns retry
     *
     * @return  util.TimeSpan
     */
    public function getRetry() {
      return new TimeSpan($this->retry);
    }

    /**
     * Returns expire
     *
     * @return  util.TimeSpan
     */
    public function getExpire() {
      return new TimeSpan($this->expire);
    }

    /**
     * Returns minTtl
     *
     * @return  util.TimeSpan
     */
    public function getMinTtl() {
      return new TimeSpan($this->minTtl);
    }
    
    /**
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        "%s(%s %s, serial %d)@{\n".
        "  [refresh] %d\n".
        "  [retry]   %d\n".
        "  [expire]  %d\n".
        "  [min-ttl] %d\n".
        "}",
        $this->getClassName(),
        $this->mname,
        $this->rname,
        $this->serial,
        $this->refresh,
        $this->retry,
        $this->expire,
        $this->minTtl
      );
    }
  }
?>
