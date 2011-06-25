<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Record');

  /**
   * SRV
   *
   * @see   http://en.wikipedia.org/wiki/SRV_record
   */
  class SRVRecord extends peer·net·Record {
    protected $target, $priority, $weight;
    
    /**
     * Creates a new NS record
     *
     * @param   string name
     * @param   int ttl
     * @param   int priority
     * @param   int weight
     * @param   int port
     * @param   string target
     */
    public function __construct($name, $ttl, $priority, $weight, $port, $target) {
      parent::__construct($name, $ttl);
      $this->priority= $priority;
      $this->weight= $weight;
      $this->port= $port;
      $this->target= $target;
    }

    /**
     * Returns target
     *
     * @return  string
     */
    public function getTarget() {
      return $this->target;
    }

    /**
     * Returns priority
     *
     * @return  int
     */
    public function getPriority() {
      return $this->priority;
    }

    /**
     * Returns weight
     *
     * @return  int
     */
    public function getWeight() {
      return $this->weight;

    }
    /**
     * Returns port
     *
     * @return  int
     */
    public function getPort() {
      return $this->port;
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
        $this->priority === $cmp->priority &&
        $this->weight === $cmp->weight &&
        $this->port === $cmp->port &&
        $this->target === $cmp->target
      );
    }
    
    /**
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(ttl '.$this->ttl.' ->'.$this->target.':'.$this->port.', pri '.$this->priority.' weight '.$this->weight.')';
    }
  }
?>
