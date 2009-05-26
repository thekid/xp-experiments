<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.optimize.Optimizations',
    'xp.compiler.optimize.TryOptimization',
    'xp.compiler.ast.ReturnNode',
    'xp.compiler.ast.NullNode',
    'xp.compiler.ast.VariableNode',
    'xp.compiler.ast.TryNode',
    'xp.compiler.ast.CatchNode',
    'xp.compiler.ast.ThrowNode',
    'xp.compiler.types.TypeName'
  );

  /**
   * TestCase for Try operations
   *
   * @see      xp://xp.compiler.optimize.TryOptimization
   */
  class TryOptimizationTest extends TestCase {
    protected $fixture = NULL;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= new Optimizations();
      $this->fixture->add(new TryOptimization());
    }
    
    /**
     * Test try { ... } catch (... $e) { throw $e; } is optimized to
     * just the statements inside the try block
     *
     */
    #[@test]
    public function removeUselessTryCatch() {
      $try= new TryNode(array(
        'statements' => array(
          new ReturnNode(array('expression' => new NullNode()))
        ),
        'handling'   => array(
          new CatchNode(array(
            'type'       => new TypeName('lang.Throwable'),
            'variable'   => 'e',
            'statements' => array(new ThrowNode(array('expression' => new VariableNode('e'))))
          ))
        )
      ));
      $this->assertEquals(new StatementsNode($try->statements), $this->fixture->optimize($try));
    }
  }
?>
