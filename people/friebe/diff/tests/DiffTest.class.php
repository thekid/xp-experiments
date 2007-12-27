<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'text.diff.Difference'
  );

  /**
   * TestCase
   *
   * @see      xp://text.diff.Difference
   * @purpose  Unittest
   */
  class DiffTest extends TestCase {
  
    /**
     * Test
     *
     */
    #[@test]
    public function equalInput() {
      $this->assertEquals(
        array(
          new Copy('Hello'),
          new Copy('World')
        ), 
        Difference::between(
          array('Hello', 'World'),
          array('Hello', 'World')
        )
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function insertedInMiddle() {
      $this->assertEquals(
        array(
          new Copy('Hello'),
          new Insertion('cruel'),
          new Copy('World')
        ), 
        Difference::between(
          array('Hello', 'World'),
          array('Hello', 'cruel', 'World')
        )
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function insertedAtEnd() {
      $this->assertEquals(
        array(
          new Copy('Hello'),
          new Copy('World'),
          new Insertion('!')
        ), 
        Difference::between(
          array('Hello', 'World'),
          array('Hello', 'World', '!')
        )
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function changedAtBeginnig() {
      $this->assertEquals(
        array(
          new Change('Hello', 'Hi'),
          new Copy('World')
        ), 
        Difference::between(
          array('Hello', 'World'),
          array('Hi', 'World')
        )
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function changedAEnd() {
      $this->assertEquals(
        array(
          new Copy('Hello'),
          new Change('World', 'Master')
        ), 
        Difference::between(
          array('Hello', 'World'),
          array('Hello', 'Master')
        )
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function changedInbetween() {
      $this->assertEquals(
        array(
          new Copy('Hello'),
          new Change('World', 'Master'),
          new Copy('how are you?')
        ), 
        Difference::between(
          array('Hello', 'World', 'how are you?'),
          array('Hello', 'Master', 'how are you?')
        )
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function deletedAtEnd() {
      $this->assertEquals(
        array(
          new Copy('Hello'),
          new Deletion('World')
        ), 
        Difference::between(
          array('Hello', 'World'),
          array('Hello')
        )
      );
    }
  }
?>
