<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class NativeSoapInvocationHandler extends Object {
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct($package, $class) {
      $this->package= $package;
      $this->class= $class;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __call($method, $args) {
      try {
        $instance= Package::forName($this->package)
          ->loadClass($this->class)
          ->newInstance()
        ;

        return $instance->getClass()->getMethod($method)->invoke($instance, $args);
      } catch (XPException $e) {
        throw new SoapFault('native.internalerror', $e->getMessage(), get_class($this));
      }
    }
  }
?>
