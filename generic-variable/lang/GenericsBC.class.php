<?php
  class GenericsBC extends Type {
  	public function __construct($base, $components) {
  		$this->base= $base;
  		$this->components= $components;

  		$c= '';
  		foreach ($this->components as $component) {
  			$c= ','.$component->getName();
  		}
  		$this->name= $this->name= $base->getName().'<'.substr($c, 2).'>';
  	}

  	public function isInstance($obj) {
  		return $obj->getName() === $this->name;
  	}

  	public function newInstance() {
      $name= $this->base->literal();
      $instance= unserialize('O:'.strlen($name).':"'.$name.'":0:{}');
      $instance->__id= microtime();
      $instance->__generic= array();
      foreach ($this->components as $type) {
        $instance->__generic[]= $type->literal();
      }

      // Call constructor if available
      if (method_exists($instance, '__construct')) {
        $a= func_get_args();
        call_user_func_array(array($instance, '__construct'), array_slice($a, 1));
      }

      return $instance;
  	}
  }
?>