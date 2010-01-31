<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.checks.RoutinesVerification',
    'xp.compiler.ast.MethodNode',
    'xp.compiler.ast.InterfaceNode',
    'xp.compiler.ast.ClassNode'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.checks.RoutinesVerification
   */
  class RoutinesVerificationTest extends TestCase {
    protected $fixture= NULL;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= new RoutinesVerification();
    }
    
    /**
     * Test interface methods
     *
     */
    #[@test]
    public function interfaceMethodsMayNotHaveBodies() {
      $m= new MethodNode(array(
        'name'        => 'run',
        'modifiers'   => MODIFIER_PUBLIC,
        'returns'     => new TypeName('void'),
        'parameters'  => array(),
        'body'        => array(),
        'holder'      => new InterfaceNode(MODIFIER_PUBLIC, array(), new TypeName('Runnable'))
      ));
      $this->assertEquals(
        array('R403', 'Interface methods may not have a body Runnable::run'), 
        $this->fixture->verify($m)
      );
    }

    /**
     * Test interface methods
     *
     */
    #[@test]
    public function interfaceMethodsMayNotBePrivate() {
      $m= new MethodNode(array(
        'name'        => 'run',
        'modifiers'   => MODIFIER_PRIVATE,
        'returns'     => new TypeName('void'),
        'parameters'  => array(),
        'body'        => NULL,
        'holder'      => new InterfaceNode(MODIFIER_PUBLIC, array(), new TypeName('Runnable'))
      ));
      $this->assertEquals(
        array('R401', 'Interface methods may only be public Runnable::run'), 
        $this->fixture->verify($m)
      );
    }

    /**
     * Test interface methods
     *
     */
    #[@test]
    public function interfaceMethodsMayNotBeProtected() {
      $m= new MethodNode(array(
        'name'        => 'run',
        'modifiers'   => MODIFIER_PROTECTED,
        'returns'     => new TypeName('void'),
        'parameters'  => array(),
        'body'        => NULL,
        'holder'      => new InterfaceNode(MODIFIER_PUBLIC, array(), new TypeName('Runnable'))
      ));
      $this->assertEquals(
        array('R401', 'Interface methods may only be public Runnable::run'), 
        $this->fixture->verify($m)
      );
    }

    /**
     * Test interface methods
     *
     */
    #[@test]
    public function interfaceMethodsMayNotBeAbstract() {
      $m= new MethodNode(array(
        'name'        => 'run',
        'modifiers'   => MODIFIER_ABSTRACT,
        'returns'     => new TypeName('void'),
        'parameters'  => array(),
        'body'        => NULL,
        'holder'      => new InterfaceNode(MODIFIER_PUBLIC, array(), new TypeName('Runnable'))
      ));
      $this->assertEquals(
        array('R401', 'Interface methods may only be public Runnable::run'), 
        $this->fixture->verify($m)
      );
    }

    /**
     * Test interface methods
     *
     */
    #[@test]
    public function interfaceMethodsMayNotBeFinal() {
      $m= new MethodNode(array(
        'name'        => 'run',
        'modifiers'   => MODIFIER_FINAL,
        'returns'     => new TypeName('void'),
        'parameters'  => array(),
        'body'        => NULL,
        'holder'      => new InterfaceNode(MODIFIER_PUBLIC, array(), new TypeName('Runnable'))
      ));
      $this->assertEquals(
        array('R401', 'Interface methods may only be public Runnable::run'), 
        $this->fixture->verify($m)
      );
    }

    /**
     * Test class methods
     *
     */
    #[@test]
    public function abstractMethodsMayNotHaveBodies() {
      $m= new MethodNode(array(
        'name'        => 'run',
        'modifiers'   => MODIFIER_ABSTRACT,
        'returns'     => new TypeName('void'),
        'parameters'  => array(),
        'body'        => array(),
        'holder'      => new ClassNode(MODIFIER_PUBLIC, array(), new TypeName('Runner'))
      ));
      $this->assertEquals(
        array('R403', 'Abstract methods may not have a body Runner::run'), 
        $this->fixture->verify($m)
      );
    }

    /**
     * Test class methods
     *
     */
    #[@test]
    public function nonAbstractMethodsMustHaveBodies() {
      $m= new MethodNode(array(
        'name'        => 'run',
        'modifiers'   => MODIFIER_PUBLIC,
        'returns'     => new TypeName('void'),
        'parameters'  => array(),
        'body'        => NULL,
        'holder'      => new ClassNode(MODIFIER_PUBLIC, array(), new TypeName('Runner'))
      ));
      $this->assertEquals(
        array('R401', 'Non-abstract methods must have a body Runner::run'), 
        $this->fixture->verify($m)
      );
    }
  }
?>
