<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Record');

  /**
   * MX
   *
   */
  class MXRecord extends peer·net·Record {
    protected $priority, $target;

    /**
     * Creates a new MX record
     *
     * @param   string name
     * @param   int ttl
     * @param   int priority
     * @param   string target
     */
    public function __construct($name, $ttl, $priority, $target) {
      parent::__construct($name, $ttl);
      $this->priority= $priority;
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
        $this->target === $cmp->target
      );
    }

    /**
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(ttl '.$this->ttl.' ->'.$this->target.', pri '.$this->priority.')';
    }
  }
?>
