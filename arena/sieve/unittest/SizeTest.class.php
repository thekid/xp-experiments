<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase
   *
   * @see      xp://peer.sieve.SizeCondition
   * @purpose  Unittest
   */
  class SizeTest extends SieveParserTestCase {

    /**
     * Test :over
     *
     */
    #[@test]
    public function largerThanCondition() {
      $condition= $this->parseCommandSetFrom('if size :over 1000 { discard; }')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.LargerThanCondition');
      $this->assertEquals(1000, $condition->value);
    }
    
    /**
     * Test :under
     *
     */
    #[@test]
    public function smallerThanCondition() {
      $condition= $this->parseCommandSetFrom('if size :under 1000 { discard; }')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.SmallerThanCondition');
      $this->assertEquals(1000, $condition->value);
    }

    /**
     * Test "K" quantifier
     *
     */
    #[@test]
    public function kilobyteQuantifier() {
      $this->assertEquals(
        102400,
        $this->parseCommandSetFrom('if size :over 100k { discard; }')->commandAt(0)->condition->value
      );
    }

    /**
     * Test "M" quantifier
     *
     */
    #[@test]
    public function megabyteQuantifier() {
      $this->assertEquals(
        2097152,
        $this->parseCommandSetFrom('if size :over 2M { discard; }')->commandAt(0)->condition->value
      );
    }

    /**
     * Test "G" quantifier
     *
     */
    #[@test]
    public function gigabyteQuantifier() {
      $this->assertEquals(
        1073741824,
        $this->parseCommandSetFrom('if size :over 1G { discard; }')->commandAt(0)->condition->value
      );
    }

    /**
     * Test illegal quantifier
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function illegalQuantifier() {
      $this->parse('if size :over 1X { discard; }');
    }

    /**
     * Test :exceeds is not a valid argument
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function invalidArgument() {
      $this->parse('if size :exceeds 1000 { discard; }');
    }
  }
?>
