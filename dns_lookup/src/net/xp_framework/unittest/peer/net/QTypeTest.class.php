<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.net.QType'
  );

  /**
   * TestCase
   *
   * @see   xp://peer.net.QType
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
    public function coverage() {
      foreach (QType::values() as $qtype) {
        $this->assertEquals($qtype, QType::named($qtype->name()), $qtype->name());
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
