<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.net.Question',
    'peer.net.QType',
    'peer.net.QClass'
  );

  /**
   * TestCase
   *
   * @see   xp://peer.net.Question
   */
  class QuestionTest extends TestCase {
  
    /**
     * Test equals() method
     *
     */
    #[@test]
    public function equality() {
      $this->assertEquals(
        new Question('example.com', QType::$A, QClass::$IN),
        new Question('example.com', QType::$A, QClass::$IN)
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function withDifferentTypeNotEqual() {
      $this->assertNotEquals(
        new Question('example.com', QType::$A, QClass::$IN),
        new Question('example.com', QType::$AAAA, QClass::$IN)
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function withDifferentClassNotEqual() {
      $this->assertNotEquals(
        new Question('example.com', QType::$A, QClass::$IN),
        new Question('example.com', QType::$A, QClass::$CH)
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function withDifferentNameNotEqual() {
      $this->assertNotEquals(
        new Question('example.com', QType::$A, QClass::$IN),
        new Question('a.example.com', QType::$A, QClass::$IN)
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function notEqualToMessage() {
      $this->assertNotEquals(
        new Question('example.com', QType::$A, QClass::$IN),
        new peer·net·Message()
      );
    }
  }
?>
