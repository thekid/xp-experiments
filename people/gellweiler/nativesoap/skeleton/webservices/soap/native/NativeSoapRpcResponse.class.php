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
      
      // TODO change contenttype header
      //$this->setHeader('Content-type', 'text/xml');
      if (NULL !== $this->message->getFault()) {
        $this->setStatus(HTTP_INTERNAL_SERVER_ERROR);
      }
      
      $this->content= $this->message->serializeData();
    }
  }
?>
