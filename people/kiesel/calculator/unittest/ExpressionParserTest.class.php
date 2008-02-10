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
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function setUp() {
      $this->fixture= new ExpressionParser();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function astFor($expr) {
      return $this->fixture->parse(new calc·Lexer($expr, '<unittest>'));
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function evaluate($expr) {
      return $this->astFor($expr)->evaluate();
    }    
      
    /**
     * Test
     *
     */
    #[@test]
    public function simpleAdditionParse() {
      $this->assertEquals(
        new Addition(
          new Value('1'),
          new Value('2')
        ),
        $this->fixture->parse(new calc·Lexer('1 + 2 ', '<unittest>')) // trailing ws needed!
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleAdditionEvaluate() {
      $this->assertEquals(3, $this->evaluate('1 + 2'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleProductEvaluate() {
      $this->assertEquals(6, $this->evaluate('2 * 3'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleDifferenceEvaluate() {
      $this->assertEquals(-1, $this->evaluate('2 - 3'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleQuotientEvaluate() {
      $this->assertEquals(2, $this->evaluate('4 / 2'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleNumberEvaluate() {
      $this->assertEquals(5, $this->evaluate('5'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleNegativeNumberEvaluate() {
      $this->assertEquals(-5, $this->evaluate('-5'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleNegativeNumberProduct() {
      $this->assertEquals(1, $this->evaluate('(-1) * (-1)'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function moduloParse() {
      $this->assertEquals(
        new Modulo(
          new Value('9'),
          new Value('7')
        ),
        $this->astFor('9 % 7')
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function moduloEvaluate() {
      $this->assertEquals(2, $this->evaluate('9 % 7'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function powerParse() {
      $this->assertEquals(
        new Power(
          new Value('2'),
          new Value('10')
        ),
        $this->astFor('2^10')
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function powerEvaluate() {
      $this->assertEquals(1024, $this->evaluate('2 ^ 10'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleDoubleParse() {
      $this->assertEquals(
        new Value('1.5'),
        $this->astFor('1.5')
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleDoubleEvaluate() {
      $this->assertEquals(3.0, $this->evaluate('1.5 * 2'));
    }
    
    
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleBracedExpression() {
      $this->assertEquals(
        new Division(
          new Addition(
            new Value('1'),
            new Value('2')
          ),
          new Value('3')
        ),
        $this->astFor('(1 + 2) / 3')
      );
      
      $this->assertEquals(1, $this->evaluate('(1 + 2) / 3'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleExpressionChain() {
      $this->assertEquals(
        new Subtraction(
          new Subtraction(
            new Value('10'),
            new Value('5')
          ),
          new Value('5')
        ),
        $this->astFor('10 - 5 - 5')
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleExpressionChainEvaluation() {
      $this->assertEquals(0, $this->evaluate('10 - 5 - 5'));
    }
  }
?>
