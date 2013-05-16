<?php
  function newinstance($parent, $args= array(), $methods= array()) {
    static $counter= 0;
    
    // Calculate unique name
    $classname= $parent.'·'.($counter++);

    // Extend parent class
    if (interface_exists($parent)) {
      $src= 'class '.$classname.' implements '.$parent.' {';
    } else if (class_exists($parent)) {
      $src= 'class '.$classname.' extends '.$parent.' {';
    } else {
      throw new InvalidArgumentException('Class '.$parent.' does not exist');
    }
    $src.= ' public static $__methods= array();';
    
    // Build methods
    foreach ($methods as $method => $declaration) {
      
      // Build signature.
      $m= new ReflectionMethod($declaration);
      $signature= $arguments= '';
      $parameters= $m->getParameters();
      for ($i= 1, $s= sizeof($parameters); $i < $s; $i++) {
        $arguments.= ', $arg'.$i;
        if ($parameters[$i]->isArray()) {
          $signature.= ', array';;
        } else if ($class= $parameters[$i]->getClass()) {
          $signature.= ', '.$class->getName();
        } else {
          $signature.= ',';
        }
        $signature.= ' '.($parameters[$i]->isPassedByReference() ? '&' : '').'$arg'.$i;
        if ($parameters[$i]->allowsNull()) {
          $signature.= '= NULL';
        } else if ($parameters[$i]->isDefaultValueAvailable()) {
          $signature.= '= '.var_export($parameters[$i]->getDefaultValue(), TRUE);
        } else if ($parameters[$i]->isOptional()) {
          $signature.= '= NULL';
        }
      }
      
      // Create delegation method
      $src.= 'function '.$method.'('.substr($signature, 2).') { 
        $m= self::$__methods["'.$method.'"]; return $m($this, '.substr($arguments, 2).');
      }';
    }
    $src.= '} '.$classname.'::$__methods= $methods; return TRUE;';
    
    // Declare class
    if (TRUE !== eval($src)) {
      throw new RuntimeException('Could not declare '.$classname);
    }

    // Instantiate
    $c= new ReflectionClass($classname);
    return $c->getConstructor() ? $c->newInstanceArgs($args) : $c->newInstance();
  }
  
  interface Context {
  }
  
  abstract class Operation {
    abstract public function perform(Context $c= NULL);
  }
  
  $op= newinstance('Operation', array(), array(
    'perform' => function($this, Context $c= NULL) {
      var_dump($this); return $c;
    }
  ));
  var_dump($op->perform(newinstance('Context')));
?>
