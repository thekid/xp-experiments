<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.Lexer',
    'xp.compiler.Parser'
  );

  /**
   * TestCase
   *
   */
  class ComparisonTest extends TestCase {
  
    /**
     * Parse method source and return statements inside this method.
     *
     * @param   string src
     * @return  xp.compiler.Node[]
     */
    protected function parse($src) {
      return create(new Parser())->parse(new xp·compiler·Lexer('class Container {
        public void method() {
          '.$src.'
        }
      }', '<string:'.$this->name.'>'))->body['methods'][0]->body;
    }

    /**
     * Test equality comparison
     *
     */
    #[@test]
    public function equality() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 19),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 17), 'value' => '10')),
        'op'            => '=='
      ))), $this->parse('
        $i == 10;
      '));
    }

    /**
     * Test unequality comparison
     *
     */
    #[@test]
    public function unEquality() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 19),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 17), 'value' => '10')),
        'op'            => '!='
      ))), $this->parse('
        $i != 10;
      '));
    }

    /**
     * Test smaller than comparison
     *
     */
    #[@test]
    public function smallerThan() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 18),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '<'
      ))), $this->parse('
        $i < 10;
      '));
    }

    /**
     * Test smaller than or equal to comparison
     *
     */
    #[@test]
    public function smallerThanOrEqualTo() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 19),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 17), 'value' => '10')),
        'op'            => '<='
      ))), $this->parse('
        $i <= 10;
      '));
    }

    /**
     * Test greater than comparison
     *
     */
    #[@test]
    public function greaterThan() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 18),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '>'
      ))), $this->parse('
        $i > 10;
      '));
    }

    /**
     * Test greather than or equal to comparison
     *
     */
    #[@test]
    public function greaterThanOrEqualTo() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 19),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 17), 'value' => '10')),
        'op'            => '>='
      ))), $this->parse('
        $i >= 10;
      '));
    }
  }
?>
