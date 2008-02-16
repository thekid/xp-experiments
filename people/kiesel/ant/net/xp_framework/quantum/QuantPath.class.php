<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('net.xp_framework.quantum.QuantFileset');

  /**
   * Represents a path
   *
   * @purpose  Value object
   */
  class QuantPath extends Object {
    protected
      $id       =  '',
      $fileset  = NULL,
      $elements = array();
      
    /**
     * Set this path's ID
     *
     * @param   string id
     */
    #[@xmlmapping(element= '@id')]
    public function setId($id) {
      $this->id= $id;
    }

    /**
     * Get this path's ID
     *
     * @return  string id
     */
    public function getId() {
      return $this->id;
    }

    /**
     * Set fileset
     *
     * @param   net.xp_framework.quantum.QuantFileset set
     */
    #[@xmlmapping(element= 'fileset', class= 'net.xp_framework.quantum.QuantFileset')]
    public function addFileset($set) {
      $this->filesets[]= $set;
    }

    /**
     * Get fileset
     *
     * @return  net.xp_framework.quantum.QuantFileset[]
     */
    public function getFilesets() {
      return $this->filesets;
    }
  }
?>
