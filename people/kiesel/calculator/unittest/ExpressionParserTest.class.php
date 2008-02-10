<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'calc.Lexer',
    'calc.ExpressionParser'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class ExpressionParserTest extends TestCase {
  
    /**
     * Test
     *
     */
    #[@test]
    public function parse() {
      $p= new ExpressionParser();
      $this->assertEquals(
        new ExprNode(array(
          'left'  => '1',
          'operator'  => '*',
          'right'     => new ExprNode(array(
            'left'      => '1'
          ))
        )),
        $p->parse(new calc·Lexer('1 * 1', '<unittest>'))
      );
    }
  }
?>
