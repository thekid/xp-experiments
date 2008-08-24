<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @purpose  purpose
   */
  #[@entity(datasource= 'people')]
  class Person extends Object {

    #[@id, @column(name= 'person_id')]
    public $personId= 0;
    
    #[@column]
    public $realname= '';

    #[@column]
    public $lastchange= NULL;
  }
?>
