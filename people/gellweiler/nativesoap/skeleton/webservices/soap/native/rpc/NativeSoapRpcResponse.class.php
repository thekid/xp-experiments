<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses('scriptlet.rpc.AbstractRpcResponse');
  
  /**
   * Wraps SOAP response
   *
   * @see scriptlet.HttpScriptletResponse  
   */
  class NativeSoapRpcResponse extends AbstractRpcResponse {
    
    /**
     * Make sure a fault is passed as "500 Internal Server Error"
     *
     * @see     scriptlet.HttpScriptletResponse#process
     */
    public function process() {
      if (!$this->message) return;
      
      // Content-type header must be overwritten as Apache Axis
      // is throwing an exception when content-type is "text/xml"
      $this->setHeader('Content-type', 'application/soap+xml');
      
      if (NULL !== $this->message->getFault()) {
        $this->setStatus(HTTP_INTERNAL_SERVER_ERROR);
      }
      
      $this->content= $this->message->serializeData();
    }
  }
?>
