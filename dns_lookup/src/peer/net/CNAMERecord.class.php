<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Record');

  /**
   * CNAME
   *
   */
  class CNAMERecord extends peer·net·Record {
    protected $target;
    
    /**
     * Creates a new NS record
     *
     * @param   string name
     * @param   int ttl
     * @param   string target
     */   
    public function __construct($name, $ttl, $target) {
      parent::__construct($name, $ttl);
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
        $this->target === $cmp->target
      );
    }

    /**
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->name.' ttl '.$this->ttl.' ->'.$this->target.')';
    }
  }
?>
