<?php
/* This class net·xp_lang·tests·syntax·php·is part of the XP framework
 *
 * $Id$
 */

  $package= 'net.xp_lang.tests.syntax.php';

  uses('net.xp_lang.tests.syntax.php.ParserTestCase');

  /**
   * TestCase
   *
   */
  class net·xp_lang·tests·syntax·php·SilenceOperatorTest extends net·xp_lang·tests·syntax·php·ParserTestCase {

    /**
     * Test @$a[0]
     *
     */
    #[@test]
    public function arrayGet() {
      $this->assertEquals(
        array(new SilenceOperatorNode(new ChainNode(array(
          new VariableNode('a'),
          new ArrayAccessNode(new IntegerNode('0'))
        )))),
        $this->parse('@$a[0];')
      );
    }

    /**
     * Test @(string)$a
     *
     */
    #[@test]
    public function stringCast() {
      $this->assertEquals(
        array(new SilenceOperatorNode(new CastNode(array(
          'type'        => new TypeName('string'),
          'expression'  => new VariableNode('a')
        )))),
        $this->parse('@(string)$a;')
      );
    }

  }
?>
