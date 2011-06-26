<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.net.Question',
    'peer.net.QType'
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
        new Question('example.com', QType::$A, 1),
        new Question('example.com', QType::$A, 1)
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function withDifferentTypeNotEqual() {
      $this->assertNotEquals(
        new Question('example.com', QType::$A, 1),
        new Question('example.com', QType::$AAAA, 1)
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function withDifferentClassNotEqual() {
      $this->assertNotEquals(
        new Question('example.com', QType::$A, 1),
        new Question('example.com', QType::$A, 3)
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function withDifferentNameNotEqual() {
      $this->assertNotEquals(
        new Question('example.com', QType::$A, 1),
        new Question('a.example.com', QType::$A, 1)
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function notEqualToMessage() {
      $this->assertNotEquals(
        new Question('example.com', QType::$A, 1),
        new peer·net·Message()
      );
    }
  }
?>
