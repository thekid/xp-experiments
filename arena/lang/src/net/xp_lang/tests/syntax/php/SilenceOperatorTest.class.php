<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('net.xp_lang.tests.syntax.php.ParserTestCase');

  /**
   * TestCase
   *
   */
  class SilenceOperatorTest extends net·xp_lang·tests·syntax·php·ParserTestCase {

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
   }
?>
