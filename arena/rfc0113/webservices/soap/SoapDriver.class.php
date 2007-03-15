<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
    
    
//  uses();
  
  define('SOAPNATIVE',  'webservices.soap.native.NativeSoapClient');
  define('SOAPXP',      'webservices.soap.xp.XPSoapClient');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class SoapDriver extends Object {
    public
      $drivers    = array(),
      $usedriver  = SOAPXP;
      
    protected static
      $instance   = NULL;
      
    static function __static() {
      self::$instance= new self();
    }
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct() {
      $this->drivers[]= 'webservices.soap.xp.XpSoapClient';
      if (extension_loaded('soap')) {
        $this->drivers[]= 'webservices.soap.native.NativeSoapClient';
      }
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public static function getInstance() {
      return self::$instance;
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function availableDrivers() {
      return $this->drivers;
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function driverAvailable($driver) {
      // TBI
    }

    /**
     * Select Drivers
     *
     * @param   
     * @throws  lang.IllegalArgumentException
     */
    public function switchDriver() {
      if ($this->usedriver == SOAPXP) {
        $this->usedriver = SOAPNATIVE;
      } else {
        $this->usedriver = SOAPXP;
      }
    }

    /**
     * Select Drivers
     *
     * @param   
     * @throws  lang.IllegalArgumentException
     */
    public function selectDriver($driver) {
      if ($this->usedriver == SOAPXP || $this->usedriver == SOAPNATIVE) {
        $this->usedriver = $driver;
      } else {
        throw (new IllegalArgumentException('Driver '.$driver.' is not a valid Driver'));
      }
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function fromWsdl($endpoint, $uri) {
      return XPClass::forName(SOAPNATIVE)->newInstance($endpoint, $uri, TRUE);
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function fromEndpoint($endpoint, $uri) {
      if (extension_loaded('soap') && $this->usedriver == SOAPNATIVE) {
        return XPClass::forName(SOAPNATIVE)->newInstance($endpoint, $uri, FALSE);        
      } else {
        return XPClass::forName(SOAPXP)->newInstance($endpoint, $uri);
      }
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function instanciate($preferredOrder= array()) {
      // TBI
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public static function forName($url, $uri) {
      return new NativeSoapClient($url, $uri);
    }
  }
?>
