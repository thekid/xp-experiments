<?php
  class Object {
    public final static function __class() {
      return new ReflectionClass(get_called_class());
    }
  }
  
  class Date extends Object {
  
  }
  
  Reflection::export(Date::__class());
?>
