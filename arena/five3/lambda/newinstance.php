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
      
      // Build signature. TODO: It would be better to have a ReflectionClosure()
      // object!
      if ($m= $p->getMethod($method)) {
        $signature= $arguments= '';
        foreach ($m->getParameters() as $i => $parameter) { 
          $arguments.= ', $arg'.$i;
          if ($parameter->isArray()) {
            $signature.= ', array $arg'.$i;
          } else if ($class= $parameter->getClass()) {
            $signature.= ', '.$class->getName().' $arg'.$i;
          } else {
            $signature.= ', $arg'.$i;
          }
          if ($parameter->isOptional()) {
            $signature.= '= '.var_export($parameter->getDefaultValue(), TRUE);
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
    'perform' => function(Context $c) {
      return $c;
    }
  ));
  var_dump($op->perform(newinstance('Context')));
?>
