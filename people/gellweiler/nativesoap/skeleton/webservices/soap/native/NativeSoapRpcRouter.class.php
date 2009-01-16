<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
  uses(
    'scriptlet.rpc.AbstractRpcRouter',
    'webservices.soap.native.rpc.NativeSoapRpcRequest',
    'webservices.soap.native.rpc.NativeSoapRpcResponse',
    'webservices.soap.native.rpc.NativeSoapMessage',
    'webservices.soap.native.rpc.NativeSoapInvocationHandler',
    'webservices.soap.xp.XPSoapMapping'
  );

  /**
   * Serves as a working base for SOAP request passed to a CGI
   * executed in an Apache environment.
   *
   * Example:
   * <code>
   *   uses('webservices.soap.rpc.SoapRpcRouter');
   *
   *   $s= new SoapRpcRouter(new ClassLoader('info.binford6100.webservices'));
   *   try {
   *     $s->init();
   *     $response= &$s->process();
   *   } catch(HttpScriptletException $e) {
   *     // Retrieve standard "Internal Server Error"-Document
   *     $response= $e->getResponse();
   *   }
   *   $response->sendHeaders();
   *   $response->sendContent();
   *
   *   $s->finalize();
   * </code>
   *
   * Pass the classpath to the handlers to the constructor of this class
   * to where your handlers are. Handlers are the classes that do the
   * work for the requested SOAP-Action.
   *
   * Example: Let's say, the SOAP-Action passed in is Ident#echoStruct, and
   * the constructor was given the classpath info.binford6100.webservices,
   * the rpc router would look for a class with the fully qualified name
   * info.binford6100.webservices.IdentHandler and call it's method echoStruct.
   *
   * @see scriptlet.HttpScriptlet
   */
  class NativeSoapRpcRouter extends AbstractRpcRouter {
    public
      $mapping     = NULL;

    /**
     * Constructor
     *
     * @param   string package
     */
    public function __construct($package) {
      parent::__construct($package);
      $this->mapping= new XPSoapMapping();
    }
    
    /**
     * Create a request object.
     *
     * @return  webservices.soap.rpc.SoapRpcRequest
     */
    protected function _request() {
      return new NativeSoapRpcRequest($this->mapping);
    }

    /**
     * Create a response object.
     *
     * @return  webservices.soap.rpc.SoapRpcResponse
     */
    protected function _response() {
      return new NativeSoapRpcResponse();
    }
    
    /**
     * Create message object.
     *
     * @return  webservices.soap.xp.XPSoapMessage
     */
    protected function _message() {
      return new NativeSoapMessage();
    }    

    /**
     * Calls the handler that the action reflects to
     *
     * @param   webservices.xmlrpc.XmlRpcMessage message object (from request)
     * @return  mixed result of method call
     * @throws  lang.IllegalArgumentException if there is no such method
     * @throws  lang.IllegalAccessException for non-public methods
     */
    public function callReflectHandler($msg) {
      // Now create SoapServer and call handle()
      $server= new SoapServer(NULL, array(
        'soap_version'  => SOAP_1_2,
        'encoding'      => $msg->getEncoding(),
        'uri'           => 'Test'
      ));
      
      // Find out class to invoke
      $proxy= new NativeSoapInvocationHandler($this->package, $msg->getHandlerClass().'Handler');
      $server->setObject($proxy);

      ob_start();
      $server->handle($msg->getRequest());
      $response= ob_get_clean();

      $msg->setResponse($response);
      return $response;
    }   
  }
?>
