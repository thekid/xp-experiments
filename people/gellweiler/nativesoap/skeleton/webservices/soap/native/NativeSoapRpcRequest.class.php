<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses(
    'webservices.soap.rpc.SoapRpcRequest',
    'webservices.soap.native.rpc.NativeSoapMessage'
  );
  
  /**
   * Wraps SOAP Rpc Router request
   *
   * @see webservices.soap.rpc.SoapRpcRouter
   * @see scriptlet.HttpScriptletRequest
   */
  class NativeSoapRpcRequest extends SoapRpcRequest {

    /**
     * Retrieve SOAP message from request
     *
     * @return  webservices.soap.xp.XPSoapMessage message object
     */
    public function getMessage() {
      $m= NativeSoapMessage::fromString($this->getData());

      // Extract class and action
      preg_match(
        '/(.*)action=([^;]*)(.*)/',
        $this->getHeader('Content-Type'),
        $matches
      );

      list(
        $class, 
        $method
      )= explode('#', str_replace('"', '', $matches[2]));
      
      $m->setHandlerClass($class);
      $m->setMethod($method);
      $m->setMapping($this->mapping);
      
      return $m;
    }
  }
?>
