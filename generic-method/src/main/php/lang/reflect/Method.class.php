<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.reflect.Routine');

  /**
   * Represents a class method
   *
   * @see   xp://lang.XPClass
   * @see   xp://lang.reflect.Routine
   * @test  xp://net.xp_framework.unittest.reflection.MethodsTest
   * @test  xp://net.xp_framework.unittest.reflection.ReflectionTest
   */
  class Method extends Routine {
    protected $generic= NULL;
  
    /**
     * Creates a new method instance
     *
     * @param   string name
     * @param   php.ReflectionMethod reflect
     */
    public function __construct($name, $reflect) {
      parent::__construct($name, $reflect);
      if ('«»' === substr($this->_reflect->name, -2)) {
        $this->generic= $this->getAnnotation('generic', 'self');
      }
    }
  
    /**
     * Returns whether this is a generic method
     *
     * @return  bool
     */
    public function isGeneric() {
      return NULL !== $this->generic;
    }
    
    /**
     * Returns this method's name
     *
     * @return  string
     */
    public function getName() {
      return $this->generic
        ? substr($this->_reflect->name, 0, -2).'<'.$this->generic.'>'
        : $this->_reflect->name
      ;
    }

    /**
     * Returns whether this is a generic method
     *
     * @return  bool
     */
    public function genericComponents() {
      if (!$this->generic) {
        throw new IllegalStateException('Method '.$this->_reflect->name.' is not generic');
      }
      $components= array();
      foreach (explode(',', $this->generic) as $name) {
        $components[]= ltrim($name);
      }
      return $components;
    }

    /**
     * Returns this method's parameters
     *
     * @return  lang.reflect.Parameter[]
     */
    public function getParameters() {
      $parameters= parent::getParameters();
      if (NULL === $this->generic) {
        return $parameters;
      } else {
        return array_slice($parameters, 1 + substr_count($this->generic, ','));
      }
    }

    /**
     * Retrieve one of this method's parameters by its offset
     *
     * @param   int offset
     * @return  lang.reflect.Parameter or NULL if it does not exist
     */
    public function getParameter($offset) {
      return parent::getParameter($offset + (NULL === $this->generic ? 0 : 1 + substr_count($this->generic, ',')));
    }
    
    /**
     * Retrieve how many parameters this method declares (including optional 
     * ones)
     *
     * @return  int
     */
    public function numParameters() {
      return parent::numParameters() - (NULL === $this->generic ? 0 : 1 + substr_count($this->generic, ','));
    }

    /**
     * Invokes the underlying method represented by this Method object, 
     * on the specified object with the specified parameters.
     *
     * Example:
     * <code>
     *   $method= XPClass::forName('lang.Object')->getMethod('toString');
     *
     *   var_dump($method->invoke(new Object()));
     * </code>
     *
     * Example (passing arguments)
     * <code>
     *   $method= XPClass::forName('lang.types.String')->getMethod('concat');
     *
     *   var_dump($method->invoke(new String('Hello'), array('World')));
     * </code>
     *
     * Example (static invokation):
     * <code>
     *   $method= XPClass::forName('util.log.Logger')->getMethod('getInstance');
     *
     *   var_dump($method->invoke(NULL));
     * </code>
     *
     * @param   lang.Object obj
     * @param   var[] args default array()
     * @return  var
     * @throws  lang.IllegalArgumentException in case the passed object is not an instance of the declaring class
     * @throws  lang.IllegalAccessException in case the method is not public or if it is abstract
     * @throws  lang.reflect.TargetInvocationException for any exception raised from the invoked method
     */
    public function invoke($obj, $args= array()) {
      if (NULL !== $obj && !($obj instanceof $this->_class)) {
        throw new IllegalArgumentException(sprintf(
          'Passed argument is not a %s class (%s)',
          xp::nameOf($this->_class),
          xp::typeOf($obj)
        ));
      }
      
      // Check modifiers. If caller is an instance of this class, allow
      // protected method invocation (which the PHP reflection API does 
      // not).
      $m= $this->_reflect->getModifiers();
      if ($m & MODIFIER_ABSTRACT) {
        throw new IllegalAccessException(sprintf(
          'Cannot invoke abstract %s::%s',
          $this->_class,
          $this->getName()
        ));
      }
      if (!($m & MODIFIER_PUBLIC)) {
        if (!$this->accessible) {
          $t= debug_backtrace();
          if ($t[1]['class'] !== $this->_class) {
            $scope= new ReflectionClass($t[1]['class']);
            if (!$scope->isSubclassOf($this->_class)) {
              throw new IllegalAccessException(sprintf(
                'Cannot invoke %s %s::%s from scope %s',
                Modifiers::stringOf($this->getModifiers()),
                $this->_class,
                $this->getName(),
                $t[1]['class']
              ));
            }
          }
        }
        
        try {
          if ($this->_reflect->isStatic()) {
            return call_user_func(array($this->_class, '__callStatic'), "\7".$this->_reflect->getName(), (array)$args);
          } else {
            return call_user_func_array(array($obj, "\7".$this->_reflect->getName()), (array)$args);
          }
        } catch (SystemExit $e) {
          throw $e;
        } catch (Throwable $e) {
          throw new TargetInvocationException($this->_class.'::'.$this->getName().'() ~ '.$e->getMessage(), $e);
        }
      }

      try {
        return $this->_reflect->invokeArgs($obj, (array)$args);
      } catch (SystemExit $e) {
        throw $e;
      } catch (Throwable $e) {
        throw new TargetInvocationException($this->_class.'::'.$this->getName().'() invocation failed', $e);
      } catch (ReflectionException $e) {

        // This should never occur, we checked everything beforehand...
        throw new TargetInvocationException($this->_class.'::'.$this->getName().'() invocation failed', new XPException($e->getMessage()));
      }
    }
  }
?>
