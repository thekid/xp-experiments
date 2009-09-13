<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'net.xp_framework.unittest.text.csv';

  /**
   * Person value object
   *
   */
  class net·xp_framework·unittest·text·csv·Person extends Object {
    protected
      $id     = '', 
      $name   = '', 
      $email  = '';
    
    /**
     * Constructor
     *
     * @param   string id
     * @param   string name
     * @param   string email
     */
    public function __construct($id= '', $name= '', $email= '') {
      $this->id= $id;
      $this->name= $name;
      $this->email= $email;
    }
    
    /**
     * Returns whether another object is equal to this person
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return (
        $cmp instanceof self && 
        $cmp->id === $this->id &&
        $cmp->name === $this->name &&
        $cmp->email === $this->email
      );
    }
  }
?>
