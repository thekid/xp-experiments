<?php
  function newinstance($parent, $args= array(), $methods= array()) {
    static $counter= 0;
    
    // Calculate unique name
    $classname= $parent.'·'.($counter++);
    
    // Extend parent class
    $p= new ReflectionClass($parent);
    if ($p->isInterface()) {
      $s= 'class '.$classname.' implements '.$parent.' {';
    } else {
      $s= 'class '.$classname.' extends '.$parent.' {';
    }
    $s.= ' public static $__methods= array();';
    
    // Build methods
    foreach ($methods as $method => $declaration) {
      
      // Build signature.
      if ($m= new ReflectionMethod($declaration)) {
        $signature= $arguments= '';
        foreach ($m->getParameters() as $i => $parameter) { 
          $arguments.= ', $arg'.$i;
          if ($parameter->isArray()) {
            $signature.= ', array';;
          } else if ($class= $parameter->getClass()) {
            $signature.= ', '.$class->getName();
          } else {
            $signature.= ',';
          }
          $signature.= ' '.($parameter->isPassedByReference() ? '&' : '').'$arg'.$i;
          if ($parameter->allowsNull()) {
            $signature.= '= NULL';
          } else if ($parameter->isDefaultValueAvailable()) {
            $signature.= '= '.var_export($parameter->getDefaultValue(), TRUE);
          } else if ($parameter->isOptional()) {
            $signature.= '= NULL';
          }
        }
      }
      
      // Create delegation method
      $s.= 'function '.$method.'('.substr($signature, 2).') { 
        $m= self::$__methods["'.$method.'"]; return $m('.substr($arguments, 2).');
      }';
    }
    $s.= '} return TRUE;';
    
    // Declare class
    if (TRUE !== eval($s)) {
      throw new RuntimeException('Could not declare '.$classname);
    }

    // Instantiate
    $c= new ReflectionClass($classname);
    $c->setStaticPropertyValue('__methods', $methods);
    return $c->getConstructor() ? $c->newInstanceArgs($args) : $c->newInstance();
    
  }
  
  interface Context {
  }
  
  abstract class Operation {
    abstract public function perform(Context $c= NULL);
  }
  
  $op= newinstance('Operation', array(), array(
    'perform' => function(Context $c= NULL) {
      return $c;
    }
  ));
  var_dump($op->perform(newinstance('Context')));
?>
