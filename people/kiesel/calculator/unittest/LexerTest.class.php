<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'calc.Lexer'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class LexerTest extends TestCase {
  
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function lexerFor($input) {
      return new calc·Lexer($input, '<unittest>');
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function assertTokenSequence($seq, $source) {
      $lexer= $this->lexerFor($source);
      foreach ($seq as $s) {
        $lexer->advance();
        $this->assertEquals($s, $lexer->token);
      }
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function numberToken() {
      $this->assertTokenSequence(array(TOKEN_T_NUMBER), '1');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function doubleNumberToken() {
      $this->assertTokenSequence(array(TOKEN_T_NUMBER), '1.5');
    }
    
    
    /**
     * Test
     *
     */
    #[@test]
    public function binaryExpression() {
      $this->assertTokenSequence(
        array(TOKEN_T_NUMBER, ord('*'), TOKEN_T_NUMBER),
        '1 * 1'
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function bracedExpression() {
      $this->assertTokenSequence(
        array(ord('('), TOKEN_T_NUMBER, ord(')')),
        '(1)'
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function functionExpression() {
      $this->assertTokenSequence(
        array(TOKEN_T_WORD, ord('('), ord(')')),
        'pi()'
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function functionExpressionWithArgument() {
      $this->assertTokenSequence(
        array(TOKEN_T_WORD, ord('('), ord('-'), TOKEN_T_NUMBER, ord(')')),
        'abs(-15)'
      );
    }
  }
?>
