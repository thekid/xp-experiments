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
    protected
      $verbose= FALSE;

    /**
     * Constructor
     *
     * @param   string name
     * @param   bool verbose default FALSE
     */
    public function __construct($name, $verbose= FALSE) {
      parent::__construct($name);
      $this->verbose= $verbose;
    }
    
    /**
     * Helper method
     *
     * @param   string[] a
     * @param   string[] b
     * @return  text.diff.operation.AbstractOperation[]
     */
    protected function differenceBetween($from, $to) {
      return Difference::between($from, $to, $this->verbose);
    }
  
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
        $this->differenceBetween(
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
        $this->differenceBetween(
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
        $this->differenceBetween(
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
        $this->differenceBetween(
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
        $this->differenceBetween(
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
        $this->differenceBetween(
          array('Hello', 'World'),
          array('Hello')
        )
      );
    }
 
    /**
     * Test
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
 }
?>
