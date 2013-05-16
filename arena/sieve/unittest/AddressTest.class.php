<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase
   *
   * @see      xp://peer.sieve.AddressCondition
   * @purpose  Unittest
   */
  class AddressTest extends SieveParserTestCase {

    /**
     * Helper method
     *
     * @param   peer.sieve.AddressPart
     * @throws  unittest.AssertionFailedError  
     */
    protected function isFrom(AddressPart $ap, $src) {
      with ($condition= $this->parseCommandSetFrom($src)->commandAt(0)->condition); {
        $this->assertClass($condition, 'peer.sieve.condition.AddressCondition');
        $this->assertEquals(MatchType::is(), $condition->matchtype);
        $this->assertEquals($ap, $condition->addresspart);
        $this->assertEquals(array('from'), $condition->headers);
        $this->assertEquals(array('key'), $condition->keys);
      }
    }

    /**
     * Test
     *
     */
    #[@test]
    public function isAllFrom() {
      $this->isFrom(AddressPart::$all, 'if address :is :all "from" "key" { discard; }');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function isDomainFrom() {
      $this->isFrom(AddressPart::$domain, 'if address :is :domain "from" "key" { discard; }');
    }


    /**
     * Test
     *
     */
    #[@test]
    public function isLocalpartFrom() {
      $this->isFrom(AddressPart::$localpart, 'if address :is :localpart "from" "key" { discard; }');
    }

    /**
     * Test
     *
     * @see   rfc://5233
     */
    #[@test]
    public function isUserFrom() {
      $this->isFrom(AddressPart::$user, 'if address :is :user "from" "key" { discard; }');
    }

    /**
     * Test
     *
     * @see   rfc://5233
     */
    #[@test]
    public function isDetailFrom() {
      $this->isFrom(AddressPart::$detail, 'if address :is :detail "from" "key" { discard; }');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function contains() {
      $condition= $this->parseCommandSetFrom('
        if address :contains ["To","TO","Cc","CC"] "tsk@example.com" {
           discard;
        }
      ')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.AddressCondition');
      $this->assertEquals(MatchType::contains(), $condition->matchtype);
      $this->assertEquals(array('To', 'TO', 'Cc', 'CC'), $condition->headers);
      $this->assertEquals(array('tsk@example.com'), $condition->keys);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function matches() {
      $condition= $this->parseCommandSetFrom('
        if address :matches ["To", "Cc"] ["coyote@**.com", "wile@**.com"] {
           fileinto "INBOX.business.${2}"; stop;
        }
      ')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.AddressCondition');
      $this->assertEquals(MatchType::matches(), $condition->matchtype);
      $this->assertEquals(array('To', 'Cc'), $condition->headers);
      $this->assertEquals(array('coyote@**.com', 'wile@**.com'), $condition->keys);
    }
  }
?>
