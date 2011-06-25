<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Record');

  /**
   * NS
   *
   */
  class NSRecord extends peer·net·Record {
    protected $target;
    
    /**
     * Creates a new NS record
     *
     * @param   string name
     * @param   string target
     */
    public function __construct($name, $target) {
      parent::__construct($name);
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
        $this->name === $this->name && 
        $this->target === $cmp->target
      );
    }
    
    /**
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(->'.$this->target.')';
    }
  }
?>
