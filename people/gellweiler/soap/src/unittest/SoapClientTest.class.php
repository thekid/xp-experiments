<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'unittest.dummy.DummySoapTransport',
    'unittest.dummy.DummyService',
    'webservices.soap.xp.XPSoapClient'
  );

  /**
   * XP soap client test
   *
   * @see      xp://webservices.soap.xp.XPSoapClient
   * @purpose  test case
   */
  class SoapClientTest extends TestCase {

    /**
     * Test
     *
     */
    #[@test]
    public function createForHttp() {
      $client= new DummyService();
      $this->assertClass($client->getTransport(), 'webservices.soap.transport.SoapHttpTransport');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function createForMock() {
      $client= new DummyService('http://localhost');
      $client->setTransport(new DummySoapTransport());
      $this->assertClass($client->getTransport(), 'unittest.dummy.DummySoapTransport');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function servicenameAndNamespaceAreSet() {
      $client= new DummyService();
      $this->assertEquals('InteropTestSoapBinding', $client->getName());
      $this->assertEquals('http://soapinterop.org/', $client->getNamespace());
    }
  }
?>
