<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'webservices.soap.transport.SoapHttpTransport',
    'webservices.soap.xp.StubInfoManager'
  );

  /**
   * XP soap client
   *
   * @purpose  Generic SOAP client base class
   */
  abstract class XPSoapClient extends Object {
    public
      $transport    = NULL,
      $name         = NULL,
      $namespace    = NULL,
      $stubInfo     = NULL;

    /**
     * Get name
     *
     * @return  string
     */
    public function getName() {
      return $this->stubInfo->getServiceName();
    }

    /**
     * Get namespace
     *
     * @return  string
     */
    public function getNamespace() {
      return $this->stubInfo->getServiceNamespace();
    }


    /**
     * Constructor
     *
     */
    public function __construct() {
      $this->transport= new SoapHttpTransport();
      $this->stubInfo= StubInfoManager::getTypeStub($this->getClass());
    }

    /**
     * Set transport
     *
     * @param   webservices.soap.transport.SoapTransport transport
     */
    public function setTransport(SoapTransport $transport) {
      $this->transport= $transport;
    }

    /**
     * Get transport
     *
     * @return  webservices.soap.transport.SoapTransport
     */
    public function getTransport() {
      return $this->transport;
    }




  }
?>
