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

    /**
     * Test a real life example response
     *
     */
    #[@test]
    public function thekidDotDeLookup() {
      $fixture= $this->newInstance(
        "\006thekid\002de\000\000\377\000\001\300\014\000\001\000\001\000\000\004v\000\004R".
        "\245Xw\300\014\000\006\000\001\000\000Q\277\000/\003ns5\007schlund\300\023\012hostmaster".
        "\300;w\240\336\007\000\000p\200\000\000\034 \000\011:\200\000\001Q\200\300\014\000\017".
        "\000\001\000\000Q\277\000\011\000\012\004mx01\300;\300\014\000\017\000\001\000\000Q\277".
        "\000\011\000\012\004mx00\300;\300\014\000\002\000\001\000\000Q\277\000\002\3007\300\014".
        "\000\002\000\001\000\000Q\277\000\006\003ns6\300;*"
      );
      
      // Question
      $this->assertEquals('thekid.de', $fixture->readDomain());
      $r= unpack('ntype/nclass', $fixture->read(4));
      $this->assertEquals(255, $r['type']);           // ANY
      
      $this->assertEquals(
        new ARecord('thekid.de', 1142, '82.165.88.119'), 
        $fixture->readRecord(), 
        'A'
      );
      $this->assertEquals(
        new SOARecord('thekid.de', 20927, 'ns5.schlund.de', 'hostmaster.schlund.de', 2007031303, 28800, 7200, 604800, 86400),
        $fixture->readRecord(), 
        'SOA'
      );
      $this->assertEquals(
        new MXRecord('thekid.de', 20927, 10, 'mx01.schlund.de'),
        $fixture->readRecord(), 
        'Primary MX'
      );
      $this->assertEquals(
        new MXRecord('thekid.de', 20927, 10, 'mx00.schlund.de'),
        $fixture->readRecord(), 
        'Secondary MX'
      );
      $this->assertEquals(
        new NSRecord('thekid.de', 20927, 'ns5.schlund.de'),
        $fixture->readRecord(), 
        'Primary NS'
      );
      $this->assertEquals(
        new NSRecord('thekid.de', 20927, 'ns6.schlund.de'),
        $fixture->readRecord(), 
        'Secondary NS'
      );
      
      // @end
      $this->assertEquals('*', $fixture->read(1));
    }
  }
?>
