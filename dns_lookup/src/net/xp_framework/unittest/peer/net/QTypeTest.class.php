<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.net.dns.QType'
  );

  /**
   * TestCase
   *
   * @see   xp://peer.net.dns.QType
   */
  class QTypeTest extends TestCase {
  
    /**
     * Test named() method
     *
     */
    #[@test]
    public function namedA() {
      $this->assertEquals(QType::$A, QType::named('A'));
    }

    /**
     * Test named() method
     *
     */
    #[@test]
    public function namedMethodCoverage() {
      foreach (QType::values() as $qtype) {
        $this->assertEquals($qtype, QType::named($qtype->name()), $qtype->name());
      }
    }

    /**
     * Test withId() method
     *
     */
    #[@test]
    public function withId1() {
      $this->assertEquals(QType::$A, QType::withId(1));
    }

    /**
     * Test withId() method
     *
     */
    #[@test]
    public function withIdMethodCoverage() {
      foreach (QType::values() as $qtype) {
        $this->assertEquals($qtype, QType::withId($qtype->ordinal()), $qtype->name());
      }
    }

    /**
     * Test named() method
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function lowerCaseNamesNotSupported() {
      QType::named('a');
    }

    /**
     * Test named() method
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function emptyName() {
      QType::named('');
    }

    /**
     * Test named() method
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function nonExistantName() {
      QType::named('AAA');
    }
  }
?>
