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
     * Creates a new record
     *
     * @param   string name
     * @param   int ttl
     */
    public function __construct($name, $ttl) {
      $this->name= $name;
      $this->ttl= $ttl;
    }
    
    /**
     * Gets name
     *
     * @return  string
     */
    public function getName() {
      return $this->name;
    }

    /**
     * Gets name
     *
     * @return  string
     */
    public function getTtl() {
      return $this->ttl;
    }
  }
?>
