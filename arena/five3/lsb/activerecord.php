<?php
  abstract class ActiveRecord {
  
    public static function getByPK($id) {
      $instance= new static();
      $instance->{static::$primary}= $id;
      return $instance;
    }
  }
  
  class Person extends ActiveRecord {
    public $personId;
    public static $primary= 'personId';
  }
  
  var_dump(Person::getByPK(1));
?>
