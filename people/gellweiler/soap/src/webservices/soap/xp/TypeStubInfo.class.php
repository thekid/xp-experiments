<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Type stub info representation
   *
   * @purpose  type info
   */
  class TypeStubInfo extends Object {
    protected
      $serviceName       = NULL,
      $serviceNamespace  = NULL;

    /**
     * Constructor
     *
     * @param   lang.XPClass
     */
    public function __construct(XPClass $class) {
      $this->assembleBindingInfo($class->getAnnotation('binding'));
    }

    /**
     * Retrieve webservice name and namespace
     * from annotation
     *
     * @param   mixed info
     */
    protected function assembleBindingInfo(array $info) {
      if (!isset($info['name'])) {
        throw new ElementNotFoundException('No webservice name in binding annotation');
      }

      if (!isset($info['namespace'])) {
        throw new ElementNotFoundException('No namespace in binding annotation');
      }
      
      $this->serviceName= $info['name'];
      $this->serviceNamespace= $info['namespace'];
    }

    /**
     * Set serviceName
     *
     * @param   string serviceName
     */
    public function setServiceName($serviceName) {
      $this->serviceName= $serviceName;
    }

    /**
     * Get serviceName
     *
     * @return  string
     */
    public function getServiceName() {
      return $this->serviceName;
    }

    /**
     * Set serviceNamespace
     *
     * @param   string serviceNamespace
     */
    public function setServiceNamespace($serviceNamespace) {
      $this->serviceNamespace= $serviceNamespace;
    }

    /**
     * Get serviceNamespace
     *
     * @return  string
     */
    public function getServiceNamespace() {
      return $this->serviceNamespace;
    }


  }
?>
