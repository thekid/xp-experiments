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
     * @param   int priority
     * @param   int weight
     * @param   int port
     * @param   string target
     */
    public function __construct($name, $priority, $weight, $port, $target) {
      parent::__construct($name);
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
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(->'.$this->target.':'.$this->port.', pri '.$this->priority.' weight '.$this->weight.')';
    }
  }
?>
