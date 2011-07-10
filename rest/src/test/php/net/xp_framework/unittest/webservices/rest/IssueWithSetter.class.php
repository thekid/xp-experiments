<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'net.xp_framework.unittest.webservices.rest';

  /**
   * Isuse
   *
   */
  class net·xp_framework·unittest·webservices·rest·IssueWithSetter extends Object {
    protected $title= NULL;
    
    /**
     * Constructor
     *
     * @param   string title
     */
    public function __construct($title= NULL) {
      $this->title= $title;
    }
    
    /**
     * Set title
     *
     * @param   string title
     */
    public function setTitle($title) {
      $this->title= $title;
    }
    
    /**
     * Checks whether another object is equal to this issue
     *
     * @param   var cmp
     * @return  bool
     */
    public function equals($cmp) {
      return $cmp instanceof self && $cmp->title === $this->title;
    }
  }
?>
