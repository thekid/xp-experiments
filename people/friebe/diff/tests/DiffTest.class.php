<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'text.diff.Difference',
    'text.diff.source.ArraySource'
  );

  /**
   * TestCase
   *
   * @see      xp://text.diff.Difference
   * @purpose  Unittest
   */
  class DiffTest extends TestCase {
    
    /**
     * Helper method
     *
     * @param   string[] a
     * @param   string[] b
     * @return  text.diff.operation.AbstractOperation[]
     */
    protected function differenceBetween($from, $to) {
      return Difference::between(new ArraySource($from), new ArraySource($to))->operations();
    }
  
    /**
     * Test equal input in copy-operations for every input item.
     *
     */
    #[@test]
    public function equalInput() {
      $this->assertEquals(
        array(
          new Copy('Hello'),
          new Copy('World')
        ), 
        $this->differenceBetween(
          array('Hello', 'World'),
          array('Hello', 'World')
        )
      );
    }

    /**
     * Test completely different input results in deletion of every
     * item and insertion of every new item.
     *
     */
    #[@test]
    public function completelyDifferentInput() {
      $this->assertEquals(
        array(
          new Deletion('A'),
          new Deletion('B'),
          new Deletion('C'),
          new Insertion('X'),
          new Insertion('Y'),
          new Insertion('Z'),
        ), 
        $this->differenceBetween(
          array('A', 'B', 'C'),
          array('X', 'Y', 'Z')
        )
      );
    }

    /**
     * Test a more complex scenario (derived from a lang.base.php patch)
     *
     */
    #[@test]
    public function unevenDeletesAndInserts() {
      $this->assertEquals(
        array(
          new Deletion('sscanf'),
          new Deletion('acquire'),
          new Deletion('isset'),
          new Insertion('list'),
          new Insertion('$this'),
          new Insertion('$this'),
          new Insertion('if'),
          new Insertion('return'),
          new Copy('}'),
          new Copy('function'),
        ), 
        $this->differenceBetween(
          array('sscanf', 'acquire', 'isset', '}', 'function'),
          array('list', '$this', '$this', 'if', 'return', '}', 'function')
        )
      );
    }

    /**
     * Test insertion of input in the middle.
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
        $this->differenceBetween(
          array('Hello', 'World'),
          array('Hello', 'cruel', 'World')
        )
      );
    }

    /**
     * Test insertion of a word in the beginning.
     *
     */
    #[@test]
    public function insertedAtBeginning() {
      $this->assertEquals(
        array(
          new Insertion('Well'),
          new Copy('Hello'),
          new Copy('World')
        ), 
        $this->differenceBetween(
          array('Hello', 'World'),
          array('Well', 'Hello', 'World')
        )
      );
    }

    /**
     * Test insertion of a word at the end.
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
        $this->differenceBetween(
          array('Hello', 'World'),
          array('Hello', 'World', '!')
        )
      );
    }

    /**
     * Test change at the beginning of input.
     *
     */
    #[@test]
    public function changedAtBeginnig() {
      $this->assertEquals(
        array(
          new Change('Hello', 'Hi'),
          new Copy('World')
        ), 
        $this->differenceBetween(
          array('Hello', 'World'),
          array('Hi', 'World')
        )
      );
    }

    /**
     * Test change at the end of input.
     *
     */
    #[@test]
    public function changedAtEnd() {
      $this->assertEquals(
        array(
          new Copy('Hello'),
          new Change('World', 'Master')
        ), 
        $this->differenceBetween(
          array('Hello', 'World'),
          array('Hello', 'Master')
        )
      );
    }

    /**
     * Test change in the middle of input
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
        $this->differenceBetween(
          array('Hello', 'World', 'how are you?'),
          array('Hello', 'Master', 'how are you?')
        )
      );
    }

    /**
     * Test deletion at the end of input
     *
     */
    #[@test]
    public function deletedAtEnd() {
      $this->assertEquals(
        array(
          new Copy('Hello'),
          new Deletion('World')
        ), 
        $this->differenceBetween(
          array('Hello', 'World'),
          array('Hello')
        )
      );
    }
 
    /**
     * Test deletion in the middle of input. Also tests that common
     * elements found later on are not considered
     *
     */
    #[@test]
    public function deletedInBetween() {
      $this->assertEquals(
        array(
          new Copy('Hello'),
          new Copy('World'),
          new Deletion('Hello'),
          new Copy('World'),
        ), 
        $this->differenceBetween(
          array('Hello', 'World', 'Hello', 'World'),
          array('Hello', 'World', 'World')
        )
      );
    }

    /**
     * Test deletion at the beginning of input. Basically reverse 
     * situation as in insertedAtBeginning test.
     *
     */
    #[@test]
    public function deletedAtBeginning() {
      $this->assertEquals(
        array(
          new Deletion('Well'),
          new Copy('Hello'),
          new Copy('World')
        ), 
        $this->differenceBetween(
          array('Well', 'Hello', 'World'),
          array('Hello', 'World')
        )
      );
    }

    /**
     * Tests multiple changes at the beginning.
     *
     */
    #[@test]
    public function multipleChangesAtBeginning() {
      $this->assertEquals(
        array(
          new Deletion('Well'),
          new Deletion('Hi'),
          new Insertion('Hello'),
          new Copy('World')
        ), 
        $this->differenceBetween(
          array('Well', 'Hi', 'World'),
          array('Hello', 'World')
        )
      );
    }
  }
?>
