<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.ast.StatementsNode',
    'xp.compiler.ast.AssignmentNode',
    'xp.compiler.ast.VariableNode',
    'xp.compiler.ast.ChainNode',
    'xp.compiler.ast.IntegerNode',
    'xp.compiler.ast.LocalsToMemberPromoter'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.ast.LocalsToMemberPromoter
   */
  class LocalsToMemberPromoterTest extends TestCase {
    protected $fixture= NULL;
  
    /**
     * Creates fixture
     *
     */
    public function setUp() {
      $this->fixture= new LocalsToMemberPromoter();
    }
    
    /**
     * Creates a member node
     *
     * @param   string name
     * @return  xp.compiler.ast.ChainNode
     */
    protected function memberNode($name) {
      return new ChainNode(array(new VariableNode('this'), new VariableNode($name)));
    }
  
    /**
     * Test
     *
     */
    #[@test]
    public function basic() {
      $assignment= new AssignmentNode(array(
        'variable'      => new VariableNode('i'),
        'expression'    => new IntegerNode(array('value' => '0')),
        'op'            => '='
      ));
      $replaced= $this->fixture->promote($assignment);
      $this->assertEquals(array('$i' => $this->memberNode('i')), $replaced);
      $this->assertEquals(
        new AssignmentNode(array(
          'variable'      => $this->memberNode('i'),
          'expression'    => new IntegerNode(array('value' => '0')),
          'op'            => '='
        )),
        $assignment
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withExclusion() {
      $assignment= new AssignmentNode(array(
        'variable'      => new VariableNode('i'),
        'expression'    => new VariableNode('a'),
        'op'            => '='
      ));
      $this->fixture->exclude('a');
      $replaced= $this->fixture->promote($assignment);
      $this->assertEquals(array('$i' => $this->memberNode('i')), $replaced);
      $this->assertEquals(
        new AssignmentNode(array(
          'variable'      => $this->memberNode('i'),
          'expression'    => new VariableNode('a'),
          'op'            => '='
        )),
        $assignment
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function memberNodesArentTouched() {
      $assignment= new AssignmentNode(array(
        'variable'      => new VariableNode('i'),
        'expression'    => $this->memberNode('i'),
        'op'            => '='
      ));
      $replaced= $this->fixture->promote($assignment);
      $this->assertEquals(array('$i' => $this->memberNode('i')), $replaced);
      $this->assertEquals(
        new AssignmentNode(array(
          'variable'      => $this->memberNode('i'),
          'expression'    => $this->memberNode('i'),
          'op'            => '='
        )),
        $assignment
      );
    }
  }
?>
