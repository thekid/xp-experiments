<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Record');

  /**
   * (Insert class' description here)
   *
   */
  class CNAMERecord extends peer·net·Record {
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
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(->'.$this->target.')';
    }
  }
?>
