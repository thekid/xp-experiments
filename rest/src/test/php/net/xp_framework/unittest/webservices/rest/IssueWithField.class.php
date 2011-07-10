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
  class net·xp_framework·unittest·webservices·rest·IssueWithField extends Object {
    public $title= NULL;
    
    /**
     * Constructor
     *
     * @param   string title
     */
    public function __construct($title= NULL) {
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
