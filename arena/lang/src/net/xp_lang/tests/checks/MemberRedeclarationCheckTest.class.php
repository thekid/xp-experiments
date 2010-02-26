<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.checks.MemberRedeclarationCheck',
    'xp.compiler.ast.InterfaceNode',
    'xp.compiler.ast.EnumNode',
    'xp.compiler.ast.ClassNode',
    'xp.compiler.ast.MethodNode',
    'xp.compiler.ast.FieldNode',
    'xp.compiler.ast.EnumMemberNode',
    'xp.compiler.types.CompilationUnitScope'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.checks.MemberRedeclarationCheck
   */
  class MemberRedeclarationCheckTest extends TestCase {
    protected $fixture= NULL;
    protected $scope= NULL;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= new MemberRedeclarationCheck();
      $this->scope= new CompilationUnitScope();
    }
    
    /**
     * Test interface
     *
     */
    #[@test]
    public function interfaceWithDuplicateMethod() {
      $this->assertEquals(
        array('C409', 'Cannot redeclare Runnable::xp.compiler.ast.MethodNode<run>'), 
        $this->fixture->verify(
          new InterfaceNode(MODIFIER_PUBLIC, array(), new TypeName('Runnable'), array(), array(
            new MethodNode(array('name' => 'run')),
            new MethodNode(array('name' => 'run')),
          )), 
          $this->scope
        )
      );
    }

    /**
     * Test interface
     *
     */
    #[@test]
    public function interfaceWithTwoMethods() {
      $this->assertNull(
        $this->fixture->verify(
          new InterfaceNode(MODIFIER_PUBLIC, array(), new TypeName('Runnable'), array(), array(
            new MethodNode(array('name' => 'run')),
            new MethodNode(array('name' => 'runnable')),
          )), 
          $this->scope
        )
      );
    }

    /**
     * Test class
     *
     */
    #[@test]
    public function classWithDuplicateMethod() {
      $this->assertEquals(
        array('C409', 'Cannot redeclare Runner::xp.compiler.ast.MethodNode<run>'), 
        $this->fixture->verify(
          new ClassNode(MODIFIER_PUBLIC, array(), new TypeName('Runner'), NULL, array(), array(
            new MethodNode(array('name' => 'run')),
            new MethodNode(array('name' => 'run')),
          )), 
          $this->scope
        )
      );
    }

    /**
     * Test class
     *
     */
    #[@test]
    public function classWithTwoMethods() {
      $this->assertNull(
        $this->fixture->verify(
          new ClassNode(MODIFIER_PUBLIC, array(), new TypeName('Runner'), NULL, array(), array(
            new MethodNode(array('name' => 'run')),
            new MethodNode(array('name' => 'runnable')),
          )), 
          $this->scope
        )
      );
    }

    /**
     * Test class
     *
     */
    #[@test]
    public function classWithDuplicateField() {
      $this->assertEquals(
        array('C409', 'Cannot redeclare Runner::xp.compiler.ast.FieldNode<in>'), 
        $this->fixture->verify(
          new ClassNode(MODIFIER_PUBLIC, array(), new TypeName('Runner'), NULL, array(), array(
            new FieldNode(array('name' => 'in')),
            new FieldNode(array('name' => 'in')),
          )), 
          $this->scope
        )
      );
    }

    /**
     * Test class
     *
     */
    #[@test]
    public function classWithTwoFields() {
      $this->assertNull(
        $this->fixture->verify(
          new ClassNode(MODIFIER_PUBLIC, array(), new TypeName('Runner'), NULL, array(), array(
            new FieldNode(array('name' => 'in')),
            new FieldNode(array('name' => 'out')),
          )), 
          $this->scope
        )
      );
    }

    /**
     * Test class
     *
     */
    #[@test]
    public function classWithFieldAndMethodWithSameName() {
      $this->assertNull(
        $this->fixture->verify(
          new ClassNode(MODIFIER_PUBLIC, array(), new TypeName('Runner'), NULL, array(), array(
            new FieldNode(array('name' => 'run')),
            new MethodNode(array('name' => 'run')),
          )), 
          $this->scope
        )
      );
    }

    /**
     * Test enum
     *
     */
    #[@test]
    public function enumWithDuplicateMember() {
      $this->assertEquals(
        array('C409', 'Cannot redeclare Coin::xp.compiler.ast.EnumMemberNode<penny>'), 
        $this->fixture->verify(
          new EnumNode(MODIFIER_PUBLIC, array(), new TypeName('Coin'), NULL, array(), array(
            new EnumMemberNode(array('name' => 'penny')),
            new EnumMemberNode(array('name' => 'penny')),
          )), 
          $this->scope
        )
      );
    }

    /**
     * Test enum
     *
     */
    #[@test]
    public function enumWithTwoMembers() {
      $this->assertNull(
        $this->fixture->verify(
          new EnumNode(MODIFIER_PUBLIC, array(), new TypeName('Coin'), NULL, array(), array(
            new EnumMemberNode(array('name' => 'penny')),
            new EnumMemberNode(array('name' => 'dime')),
          )), 
          $this->scope
        )
      );
    }
  }
?>
