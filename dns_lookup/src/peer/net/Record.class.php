<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net';

  /**
   * Abstract base class for all records
   *
   */
  abstract class peer·net·Record extends Object {
    protected $name= '';

    /**
     * (Insert method's description here)
     *
     * @param   
     * @param   
     */
    public function __construct($name) {
      $this->name= $name;
    }
    
    /**
     * (Insert method's description here)
     *
     * @return  string
     */
    public function getName() {
      return $this->name;
    }
  }
?>
