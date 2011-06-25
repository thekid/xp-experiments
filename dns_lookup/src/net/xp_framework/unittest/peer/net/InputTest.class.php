<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.net.Input'
  );

  /**
   * TestCase
   *
   * @see   xp://peer.net.Input
   */
  class InputTest extends TestCase {
  
    /**
     * Creates a new Input instance
     *
     * @param   string bytes
     * @return  peer.net.Input
     */
    public function newInstance($bytes) {
      return new peer·net·Input($bytes);
    }
    
    /**
     * Test readDomain()
     *
     */
    #[@test]
    public function reverseV4Address() {
      $fixture= $this->newInstance("\003137\0011\003106\00287\007in-addr\004arpa\000*");
      $this->assertEquals('137.1.106.87.in-addr.arpa', $fixture->readDomain());
      $this->assertEquals('*', $fixture->read(1));
    }

    /**
     * Test readDomain()
     *
     */
    #[@test]
    public function domainPointer() {
      $fixture= $this->newInstance("\005xpsrv\003net\000\000\001\000\001\300\014*");
      $this->assertEquals('xpsrv.net', $fixture->readDomain());
      $fixture->read(4);
      $this->assertEquals('xpsrv.net', $fixture->readDomain());
      $this->assertEquals('*', $fixture->read(1));
    }

    /**
     * Test readLabel()
     *
     */
    #[@test]
    public function hostName() {
      $fixture= $this->newInstance("\005xpsrv\003net\000*");
      $this->assertEquals('xpsrv', $fixture->readLabel());
      $this->assertEquals('net', $fixture->readLabel());
      $this->assertNull($fixture->readLabel());
      $this->assertEquals('*', $fixture->read(1));
    }

    /**
     * Test readLabel()
     *
     */
    #[@test]
    public function labelPointer() {
      $fixture= $this->newInstance("\005xpsrv\003net\000\000\001\000\001\300\014*");
      $this->assertEquals('xpsrv', $fixture->readLabel());
      $this->assertEquals('net', $fixture->readLabel());
      $this->assertNull($fixture->readLabel());
      $fixture->read(4);
      $this->assertEquals('xpsrv', $fixture->readLabel());
      $this->assertEquals('net', $fixture->readLabel());
      $this->assertNull($fixture->readLabel());
      $this->assertEquals('*', $fixture->read(1));
    }

    /**
     * Test read()
     *
     */
    #[@test]
    public function recordHeader() {
      $fixture= $this->newInstance("\000\001\000\001\000\000V0\000\004*");
      $r= unpack('ntype/nclass/Nttl/nlength', $fixture->read(10));
      $this->assertEquals(array('type' => 1, 'class' =>1, 'ttl' => 22064, 'length' => 4), $r);
      $this->assertEquals('*', $fixture->read(1));
    }

    /**
     * Test read()
     *
     */
    #[@test]
    public function aRecord() {
      $fixture= $this->newInstance("\000\001\000\001\000\000V0\000\004Wj\001\211*");
      $fixture->read(10); // See previous test
      $ip= implode('.', unpack('Ca/Cb/Cc/Cd', $fixture->read(4)));
      $this->assertEquals('87.106.1.137', $ip);
      $this->assertEquals('*', $fixture->read(1));
    }
  }
?>
