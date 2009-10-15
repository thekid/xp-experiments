<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('webservices.soap.xp.XPSoapClient');

  /**
   * Dummy webservice
   *
   * @purpose  service client
   */
  #[@binding(name='InteropTestSoapBinding', namespace='http://soapinterop.org/')]
  class DummyService extends XPSoapClient {
  }
?>
