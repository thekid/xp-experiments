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
     * @param   int priority
     * @param   string target
     */
    public function __construct($name, $priority, $target) {
      parent::__construct($name);
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
        $this->name === $this->name && 
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
      return $this->getClassName().'(->'.$this->target.', pri '.$this->priority.')';
    }
  }
?>
