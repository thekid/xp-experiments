<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.checks.ConstantsAreDiscouraged',
    'xp.compiler.ast.ConstantNode'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.checks.ConstantsAreDiscouraged
   */
  class ConstantsAreDiscouragedTest extends TestCase {
    protected $fixture= NULL;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= new ConstantsAreDiscouraged();
    }
    
    /**
     * Test constants 
     *
     */
    #[@test]
    public function constantsAreDiscouraged() {
      $this->assertEquals(
        array('T203', 'Global constants (DIRECTORY_SEPARATOR) are discouraged'), 
        $this->fixture->verify(new ConstantNode('DIRECTORY_SEPARATOR'))
      );
    }
  }
?>
