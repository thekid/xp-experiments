<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'inject.Module', 
    'inject.Binding', 
    'lang.reflect.Proxy',
    'lang.reflect.InvocationHandler', 
    'util.invoke.PointCutExpression',
    'util.invoke.InvocationChain'
  );
  
  /**
   * Abstract base class for modules
   *
   */
  abstract class AbstractModule extends Object implements inject·Module {
    protected $bindings= array();
  
    /**
     * Constructor. Calls configure() method
     *
     */
    public function __construct() {
      $this->configure();
    }
    
    /**
     * Configure method. This is where you register bindings
     *
     */
    protected abstract function configure();
    
    /**
     * Binds a class
     *
     * @param   lang.XPClass class
     * @return  inject.Binding
     */
    public function bind(XPClass $class) {
      $n= $class->getName();
      $binding= new inject·Binding();
      if (!isset($this->bindings[$n])) {
        $this->bindings[$n]= array($binding);
      } else {
        $this->bindings[$n][]= $binding;
      }
      return $binding;
    }
    
    /**
     * Intercept
     *
     * @param   string pointcut
     * @param   util.invoke.InvocationInterceptor interceptor
     */
    public function intercept($pointcut, InvocationInterceptor $interceptor) {
      $pc= new PointCutExpression($pointcut);
      foreach ($this->bindings as $name => $bindings) {
        $class= XPClass::forName($name);
        if (!($class->equals($pc->class) || $class->isSubclassOf($pc->class))) continue;

        $cl= $class->getClassLoader();
        foreach ($bindings as $i => $binding) {
          $this->bindings[$name][$i]->toInstance(Proxy::newProxyInstance(
            $cl, 
            array($class), 
            newinstance('lang.reflect.InvocationHandler', array($binding->instance, $interceptor), '{
              public function __construct($instance, $interceptor) {
                $this->instance= $instance;
                $this->chain= new InvocationChain();
                $this->chain->addInterceptor($interceptor);
              }
              
              public function invoke($instance, $method, $args) {
                return $this->chain->invoke($this->instance, $this->instance->getClass()->getMethod($method), $args); 
              }
            }')
          ));
        }
      }
    }
  
    /**
     * Resolves a class
     *
     * @param   lang.XPClass class
     * @param   string name default NULL
     * @return  inject.Binding
     */
    public function resolve(XPClass $class, $name= NULL) {
      $n= $class->getName();
      if (!isset($this->bindings[$n])) {
        return create(new inject·Binding())->to($class);
      }
      
      if (!$name) return $this->bindings[$n][0];
      foreach ($this->bindings[$n] as $binding) {
        if ($name === $binding->name) return $binding;
      }
      return NULL;
    }
  }
?>
