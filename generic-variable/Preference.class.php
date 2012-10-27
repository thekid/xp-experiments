<?php
  #[@generic(self= 'T')]
  class Preference extends Object {
  	protected $list= array();

  	public function __construct($str) {
  	  $this->list= explode(',', $str);
  	}

  	#[@generic(return= 'T')]
  	public function match(array $supported) {
  	  /**/ $__c= get_class($this); $T= substr($__c, strpos($__c, '··')+ 2); /**/
  	  foreach ($this->list as $value) {
  	  	if (in_array($value, $supported)) return new $T($value);
  	  }
  	  return NULL;
  	}
  }
?>