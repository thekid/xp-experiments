<?php
/* This class is part of the XP framework
 *
 * $Id: Proxy.class.php 14483 2010-04-17 14:30:29Z friebe $ 
 */

  uses('lang.reflect.IProxy');
  define('PROXY_PREFIX',    'Proxy·');

  /**
   * Proxy provides static methods for creating dynamic proxy
   * classes and instances, and it is also the superclass of all
   * dynamic proxy classes created by those methods.
   *
   * @test     xp://net.xp_framework.unittest.reflection.ProxyTest
   * @purpose  Dynamically create classes
   * @see      http://java.sun.com/j2se/1.5.0/docs/api/java/lang/reflect/Proxy.html
   */
  class Proxy extends Object {   
    /**
     * @deprecated Use non-static getProxyClass instead
     * 
     * Retrieves a Proxy instance.
     *
     * @param   lang.IClassLoader classloader
     * @param   lang.XPClass[] interfaces names of the interfaces to implement
     * @return  lang.XPClass
     * @throws  lang.IllegalArgumentException
     */
    public static function getProxyClass(IClassLoader $classloader, array $interfaces) {
      $proxy= new Proxy();
      return $proxy->createProxyClass($classloader, $interfaces);
    }
    
    /**
     * Returns the XPClass object for a proxy class given a class loader 
     * and an array of interfaces.  The proxy class will be defined by the 
     * specified class loader and will implement all of the supplied 
     * interfaces (also loaded by the classloader).
     *
     * @param   lang.IClassLoader classloader
     * @param   lang.XPClass[] interfaces names of the interfaces to implement
     * @return  lang.XPClass
     * @throws  lang.IllegalArgumentException
     */
    public function createProxyClass(IClassLoader $classloader, array $interfaces, $baseClass=NULL) {
      static $num= 0;
      static $cache= array();
      
      $t= sizeof($interfaces);
      if (0 === $t) {
        throw new IllegalArgumentException('Interfaces may not be empty');
      }


      // Calculate cache key (composed of the names of all interfaces)
      $key= $classloader->hashCode().':'.implode(';', array_map(
        create_function('$i', 'return $i->getName();'), 
        $interfaces
      ));
      if (isset($cache[$key])) return $cache[$key];

      if (!$baseClass)
        $baseClass = XPClass::forName('lang.Object');

    // Create proxy class' name, using a unique identifier and a prefix
      $name= PROXY_PREFIX.($num++);
      $bytes= 'class '.$name.' extends '.xp::reflect($baseClass->getName()).' implements IProxy, ';
      $added= array();


      
      for ($j= 0; $j < $t; $j++) {
        $bytes.= xp::reflect($interfaces[$j]->getName()).', ';
      }
      $bytes= substr($bytes, 0, -2)." {\n";

      //add instance variables and constructor
      $bytes.=$this->generatePreamble();
      
      for ($j= 0; $j < $t; $j++) {
        $if= $interfaces[$j];
        
        // Verify that the Class object actually represents an interface
        if (!$if->isInterface()) {
          throw new IllegalArgumentException($if->getName().' is not an interface');
        }
        
        // Implement all the interface's methods
        foreach ($if->getMethods() as $m) {
           // Check for already declared methods, do not redeclare them
          if (isset($added[$m->getName()])) continue;
          $added[$m->getName()]= TRUE;
          $bytes.=$this->generateMethod($m);
        }
      }
      $bytes.= ' }';

      //var_dump($bytes);
      // Define the generated class
      try {
        $dyn= DynamicClassLoader::instanceFor(__METHOD__);
        $dyn->setClassBytes($name, $bytes);
        $class= $dyn->loadClass($name);
      } catch (FormatException $e) {
        throw new IllegalArgumentException($e->getMessage());
      }

      // Update cache and return XPClass object
      $cache[$key]= $class;
      
      
      return $class;
    }

    private function getHandlerName() {
      return '_h';
    }
    /**
     *
     */
    private function generatePreamble() {
      $handlerName=$this->getHandlerName();
      
      $preamble='private $'.$handlerName.'=null;'."\n\n";
      $preamble.='public function __construct($handler) {'."\n".
                 '  $this->'.$handlerName.'=$handler;'."\n".
                 "}\n";

      return $preamble;
    }
    private function generateMethod($method) {
      $bytes='';
      // Build signature and argument list
      if ($method->hasAnnotation('overloaded')) {
        $signatures= $method->getAnnotation('overloaded', 'signatures');
        $methodax= 0;
        $cases= array();
        foreach ($signatures as $signature) {
          $args= sizeof($signature);
          $methodax= max($methodax, $args- 1);
          if (isset($cases[$args])) continue;

          $cases[$args]= (
            'case '.$args.': '.
            'return $this->_h->invoke($this, \''.$method->getName(TRUE).'\', array('.
            ($args ? '$_'.implode(', $_', range(0, $args- 1)) : '').'));'
          );
        }

        // Create method
        $bytes.= (
          'function '.$method->getName().'($_'.implode('= NULL, $_', range(0, $methodax)).'= NULL) { '.
          'switch (func_num_args()) {'.implode("\n", $cases).
          ' default: throw new IllegalArgumentException(\'Illegal number of arguments\'); }'.
          '}'."\n"
        );
      } else {
        $signature= $args= '';
        foreach ($method->getParameters() as $param) {
          $restriction= $param->getTypeRestriction();
          $signature.= ', '.($restriction ? xp::reflect($restriction->getName()) : '').' $'.$param->getName();
          $args.= ', $'.$param->getName();
          $param->isOptional() && $signature.= '= '.var_export($param->getDefaultValue(), TRUE);
        }
        $signature= substr($signature, 2);
        $args= substr($args, 2);

        // Create method
        $bytes.= (
          'function '.$method->getName().'('.$signature.') { '.
          'return $this->_h->invoke($this, \''.$method->getName(TRUE).'\', array('.$args.')); '.
          '}'."\n"
        );
      }
      return $bytes;
    }
    /**
     * Returns an instance of a proxy class for the specified interfaces
     * that dispatches method invocations to the specified invocation
     * handler.
     *
     * @param   lang.ClassLoader classloader
     * @param   lang.XPClass[] interfaces
     * @param   lang.reflect.InvocationHandler handler
     * @return  lang.XPClass
     * @throws  lang.IllegalArgumentException
     */
    public function createProxyInstance($classloader, $interfaces, $handler) {
      return $this->createProxyClass($classloader, $interfaces)->newInstance($handler);
    }
    
    /**
     * @deprecated Use non-static createProxyInstance instead
     *
     * @param   lang.ClassLoader classloader
     * @param   lang.XPClass[] interfaces
     * @param   lang.reflect.InvocationHandler handler
     * @return  lang.XPClass
     * @throws  lang.IllegalArgumentException
     */
    public static function newProxyInstance($classloader, $interfaces, $handler) {
      $proxy= new Proxy();
      return $proxy->createProxyInstance($classloader, $interfaces, $handler);
    }
  }
?>
