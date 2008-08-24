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
    public $city= '';

    #[@column]
    public $phone= '';

    #[@column]
    public $mobile= '';

    #[@column]
    public $url= '';

    #[@column]
    public $lastchange= NULL;

    #[@column(name= 'changedby')]
    public $changedBy= '';

    #[@column(name= 'bz_id')]
    public $bzId;
    
    public function isActive() {
      return 20000 == $this->bzId;
    }
  }
?>
