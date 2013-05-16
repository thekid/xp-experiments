<?php
  #[@generic(self= 'T')]
  class Preference extends Object {
    protected $list= array();

    public function __construct($str) {
      $this->list= explode(',', $str);
    }

    #[@generic(return= 'T')]
    public function match(array $supported) {
      foreach ($this->list as $value) {
        if (in_array($value, $supported)) return new $T($value);
      }
      return NULL;
    }

    #[@generic(return= 'T[]')]
    public function all() {
      $r= array();
      foreach ($this->list as $value) {
        $r[]= new $T($value);
      }
      return $r;
    }
  }
?>