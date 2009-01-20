<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'xml.Tree',
    'xml.Node',
    'lang.Collection',
    'webservices.soap.CommonSoapFault',
    'webservices.soap.xp.XPSoapNode',
    'webservices.soap.xp.XPSoapHeaderElement',
    'webservices.soap.xp.XPSoapMapping',
    'scriptlet.rpc.AbstractRpcMessage'
  );
  
  /**
   * A SOAP Message consists of an envelope containing a body, and optionally,
   * headers.
   *
   * Example message in its XML representation:
   * <pre>
   * <?xml version="1.0" encoding="iso-8859-1"?>
   * <SOAP-ENV:Envelope
   *  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
   *  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
   *  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
   *  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
   *  xmlns:si="http://soapinterop.org/xsd"
   *  SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"
   *  xmlns:ctl="urn://binford/Power"
   * >
   *   <SOAP-ENV:Body>
   *     <ctl:getPower/>
   *   </SOAP-ENV:Body>
   * </SOAP-ENV:Envelope>
   * </pre>
   *
   * @see      xp://xml.Tree
   * @test     xp://net.xp_framework.unittest.soap.SoapTest
   * @purpose  Represent SOAP Message
   */
  class NativeSoapMessage extends Tree implements AbstractRpcMessage {
    const
      XMLNS_SOAPENV = 'http://www.w3.org/2003/05/soap-envelope';

    protected
      $request  = NULL,
      $response = NULL;
      
    /**
     * Constructor
     *
     * @param   string rootName default 'document'
     */
    public function __construct($rootName= 'document') {
      parent::__construct($rootName);
    }

    /**
     * Create a message
     *
     * @param   webservices.soap.xp.XPSoapMessage msg
     */
    public function create($msg= NULL) {
    }

    /**
     * Set Mapping
     *
     * @param   webservices.soap.xp.XPSoapMapping mapping
     */
    public function setMapping($mapping) {
    }
    
    /**
     * Set data
     *
     * @param   array arr
     */
    public function setData($data) {
      $this->response= $data;
    }

    /**
     * Retrieve Content-type for requests.
     *
     * @return  string
     */
    public function getContentType() { return 'text/xml'; }

    /**
     * Set fault
     *
     * @param   int faultcode
     * @param   string faultstring
     * @param   string faultactor default NULL
     * @param   mixed detail default NULL
     */    
    public function setFault($faultcode, $faultstring, $faultactor= NULL, $detail= NULL) {
      $this->fault= new SoapFault((string)$faultcode, $faultstring, $faultactor, $detail);
    }

    /**
     * Construct a SOAP message from a string
     *
     * <code>
     *   $msg= SOAPMessage::fromString('<SOAP-ENV:Envelope>...</SOAP-ENV:Envelope>');
     * </code>
     *
     * @param   string string
     * @return  xml.Tree
     */
    public static function fromString($string) {
      $m= parent::fromString($string, __CLASS__);
      $m->request= $string;
      
      with($call= $m->_bodyElement()->children[0]); {
        $method= substr($call->getName(), strpos($call->getName(), ':')+1);
        $class= (FALSE === strpos($call->getName(), ':')
          ? $call->getAttribute('xmlns')
          : array_search(substr($call->getName(), 0, strpos($call->getName(), ':')), $m->namespaces)
        );

        $m->setMethod($method);
        $m->setHandlerClass($class);
      }

      return $m;
    }

    /**
     * Construct a SOAP message from a file
     *
     * <code>
     *   $msg= SOAPMessage::fromFile(new File('foo.soap.xml');
     * </code>
     *
     * @param   io.File file
     * @return  xml.Tree
     */ 
    public static function fromFile($file) {
      return parent::fromFile($file, __CLASS__);
    }
    
    /**
     * Inspect the given node whether it contains any
     * namespace declarations. If a declaration is found,
     * register the new namespace alias in the namespaces
     * list.
     *
     * @param   xml.SOAPNode node
     */
    protected function _retrieveNamespaces($node) {
      foreach ($node->attribute as $key => $val) {
        if (0 != strncmp('xmlns:', $key, 6)) continue;
        $this->namespaces[$val]= substr($key, 6);
      }
    }
    
    /**
     * Retrieve header element or return FALSE if no header
     * exists.
     *
     * @return  xml.SOAPNode
     */
    protected function _headerElement() {
    }

    /**
     * Retrieve body element
     *
     * @return  xml.SOAPNode
     * @throws  lang.FormatException in case the body element could not be found
     */    
    public function _bodyElement() {

      // Look for namespaces in the root node
      $this->_retrieveNamespaces($this->root);
      
      // Search for the body node. For usual, this will be the first element,
      // but some SOAP clients may include a header node (which we silently 
      // ignore for now).
      for ($i= 0, $s= sizeof($this->root->children); $i < $s; $i++) {
        if (0 == strcasecmp(
          $this->root->children[$i]->getName(), 
          $this->namespaces[self::XMLNS_SOAPENV].':Body'
        )) return $this->root->children[$i];
      }

      throw new FormatException('Could not locate Body element');
    }

    /**
     * Get fault
     *
     * @return  webservices.soap.CommonSoapFault or NULL if none exists
     */
    public function getFault() {
    }
    
    /**
     * Get data
     *
     * @param   string context default 'ENUM'
     * @param   webservices.soap.xp.XPSoapMapping mapping
     * @return  mixed data
     * @throws  lang.FormatException in case no XMLNS_SOAPENV:Body was found
     */
    public function getData($context= 'ENUM') {
    }
    
    /**
     * Retrieve string representation of message as used in the
     * protocol.
     *
     * @return  string
     */
    public function serializeData() {
      if ($this->fault) throw $this->fault;
      return $this->response;
    }
    
    /**
     * Get headers from envelope.
     *
     * @return  webservices.soap.xp.XPSoapHeaderElement[]
     */
    public function getHeaders() {
    }

    /**
     * Set Class
     *
     * @param   string class
     */
    public function setHandlerClass($class) {
      $this->class= $class;
      
      // Needed in case of a SOAP fault
      $this->action= $class;
    }

    /**
     * Get Class
     *
     * @return  string
     */
    public function getHandlerClass() {
      return $this->class;
    }

    /**
     * Set Method
     *
     * @param   string method
     */
    public function setMethod($method) {
      $this->method= $method;
    }

    /**
     * Get Method
     *
     * @return  string
     */
    public function getMethod() {
      return $this->method;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function setRequest($data) {
      $this->request= $data;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getRequest() {
      return $this->request;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function setResponse($response) {
      $this->response= $response;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getResponse() {
      return $this->response;
    }    
  } 
?>
