<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.types.TypeDeclaration',
    'xp.compiler.ast.ClassConstantNode',
    'xp.compiler.ast.FieldNode',
    'xp.compiler.ast.MethodNode',
    'xp.compiler.ast.ConstructorNode',
    'xp.compiler.ast.IndexerNode',
    'xp.compiler.ast.PropertyNode',
    'xp.compiler.ast.StringNode'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.types.TypeDeclaration
   */
  class TypeDeclarationTest extends TestCase {
  
    /**
     * Test name() method
     *
     */
    #[@test]
    public function nameWithoutPackage() {
      $decl= new TypeDeclaration(new ParseTree(NULL, array(), new ClassNode(
        MODIFIER_PUBLIC, 
        NULL,
        new TypeName('TestCase')
      )));
      $this->assertEquals('TestCase', $decl->name());
    }

    /**
     * Test name() method
     *
     */
    #[@test]
    public function nameWithPackage() {
      $decl= new TypeDeclaration(new ParseTree(new TypeName('unittest.web'), array(), new ClassNode(
        MODIFIER_PUBLIC, 
        NULL,
        new TypeName('WebTestCase')
      )));
      $this->assertEquals('unittest.web.WebTestCase', $decl->name());
    }

    /**
     * Test literal() method
     *
     */
    #[@test]
    public function literalWithoutPackage() {
      $decl= new TypeDeclaration(new ParseTree(NULL, array(), new ClassNode(
        MODIFIER_PUBLIC, 
        NULL,
        new TypeName('TestCase')
      )));
      $this->assertEquals('TestCase', $decl->literal());
    }

    /**
     * Test literal() method
     *
     */
    #[@test]
    public function literalWithPackage() {
      $decl= new TypeDeclaration(new ParseTree(new TypeName('unittest.web'), array(), new ClassNode(
        MODIFIER_PUBLIC, 
        NULL,
        new TypeName('WebTestCase')
      )));
      $this->assertEquals('WebTestCase', $decl->literal());
    }

    /**
     * Test kind() method
     *
     */
    #[@test]
    public function classKind() {
      $decl= new TypeDeclaration(new ParseTree(NULL, array(), new ClassNode(
        MODIFIER_PUBLIC, 
        NULL,
        new TypeName('TestCase')
      )));
      $this->assertEquals(Types::CLASS_KIND, $decl->kind());
    }

    /**
     * Test kind() method
     *
     */
    #[@test]
    public function interfaceKind() {
      $decl= new TypeDeclaration(new ParseTree(NULL, array(), new InterfaceNode(array(
        'name' => new TypeName('Resolveable')
      ))));
      $this->assertEquals(Types::INTERFACE_KIND, $decl->kind());
    }

    /**
     * Test kind() method
     *
     */
    #[@test]
    public function enumKind() {
      $decl= new TypeDeclaration(new ParseTree(NULL, array(), new EnumNode(array(
        'name' => new TypeName('Operation')
      ))));
      $this->assertEquals(Types::ENUM_KIND, $decl->kind());
    }
    

    /**
     * Returns a type declaration for the string class
     *
     * @return  xp.compiler.emit.TypeDeclaration
     */
    protected function stringClass() {
      return new TypeDeclaration(
        new ParseTree(new TypeName('lang.types'), array(), new ClassNode(
          MODIFIER_PUBLIC, 
          NULL,
          new TypeName('String'),
          new TypeName('lang.Object'),
          NULL,
          array(
            new ClassConstantNode('ENCODING', new TypeName('string'), new StringNode('utf-8')),
            new ConstructorNode(array(
            )),
            new MethodNode(array(
              'name' => 'substring'
            )),
            new IndexerNode(array(
              'type'       => new TypeName('string'),
              'parameters' => array(array(
                'name'  => 'offset',
                'type'  => new TypeName('int'),
                'check' => TRUE
              ))
            ))
          )
        )),
        $this->objectClass()
      );
    }

    /**
     * Returns a type declaration for the object class
     *
     * @return  xp.compiler.emit.TypeDeclaration
     */
    protected function objectClass() {
      return new TypeDeclaration(
        new ParseTree(new TypeName('lang'), array(), new ClassNode(
          MODIFIER_PUBLIC, 
          NULL,
          new TypeName('Object'),
          NULL,
          NULL,
          array(
            new MethodNode(array(
              'name' => 'equals'
            ))
          )
        ))
      );
    }

    /**
     * Test hasConstructor() method
     *
     */
    #[@test]
    public function objectClassHasNoConstructor() {
      $decl= $this->objectClass();
      $this->assertFalse($decl->hasConstructor());
    }

    /**
     * Test getConstructor() method
     *
     */
    #[@test]
    public function objectClassNoConstructor() {
      $decl= $this->objectClass();
      $this->assertNull($decl->getConstructor());
    }

    /**
     * Test hasConstructor() method
     *
     */
    #[@test]
    public function stringClassHasConstructor() {
      $decl= $this->stringClass();
      $this->assertTrue($decl->hasConstructor());
    }

    /**
     * Test getConstructor() method
     *
     */
    #[@test]
    public function stringClassConstructor() {
      $decl= $this->stringClass();
      $this->assertInstanceOf('xp.compiler.types.Constructor', $decl->getConstructor());
    }

    /**
     * Test hasMethod() method
     *
     */
    #[@test]
    public function objectClassHasMethod() {
      $decl= $this->objectClass();
      $this->assertTrue($decl->hasMethod('equals'), 'equals');
      $this->assertFalse($decl->hasMethod('getName'), 'getName');
    }

    /**
     * Test hasMethod() method
     *
     */
    #[@test]
    public function stringClassHasMethod() {
      $decl= $this->stringClass();
      $this->assertTrue($decl->hasMethod('equals'), 'equals');
      $this->assertTrue($decl->hasMethod('substring'), 'substring');
      $this->assertFalse($decl->hasMethod('getName'), 'getName');
    }

    /**
     * Test hasIndexer() method
     *
     */
    #[@test]
    public function stringClassHasIndexer() {
      $decl= $this->stringClass();
      $this->assertTrue($decl->hasIndexer());
    }

    /**
     * Test hasIndexer() method
     *
     */
    #[@test]
    public function objectClassDoesNotHaveIndexer() {
      $decl= $this->objectClass();
      $this->assertFalse($decl->hasIndexer());
    }

    /**
     * Test getIndexer() method
     *
     */
    #[@test]
    public function stringClassIndexer() {
      $indexer= $this->stringClass()->getIndexer();
      $this->assertEquals(new TypeName('string'), $indexer->type);
      $this->assertEquals(array(new TypeName('int')), $indexer->parameters);
    }

    /**
     * Test isEnumerable() method
     *
     */
    #[@test]
    public function objectClassIsNotEnumerable() {
      $decl= $this->objectClass();
      $this->assertFalse($decl->isEnumerable());
    }

    /**
     * Test hasConstant() method
     *
     */
    #[@test]
    public function objectClassDoesNotHaveConstant() {
      $decl= $this->objectClass();
      $this->assertFalse($decl->hasConstant('STATUS_OK'));
    }

    /**
     * Test hasConstant() method
     *
     */
    #[@test]
    public function stringClassHasConstant() {
      $decl= $this->stringClass();
      $this->assertTrue($decl->hasConstant('ENCODING'));
    }

    /**
     * Test getConstant() method
     *
     */
    #[@test]
    public function stringClassConstant() {
      $const= $this->stringClass()->getConstant('ENCODING');
      $this->assertEquals(new TypeName('string'), $const->type);
      $this->assertEquals('utf-8', $const->value);
    }

    /**
     * Test isSubclassOf() method
     *
     */
    #[@test]
    public function stringClassSubclassOfObject() {
      $decl= $this->stringClass();
      $this->assertTrue($decl->isSubclassOf($this->objectClass()));
    }

    /**
     * Test isSubclassOf() method
     *
     */
    #[@test]
    public function extendedStringClassSubclassOfObject() {
      $decl= new TypeDeclaration(
        new ParseTree(new TypeName('lang.types'), array(), new ClassNode(
          MODIFIER_PUBLIC, 
          NULL,
          new TypeName('ExtendedString'),
          new TypeName('lang.types.String'),
          NULL,
          array()
        )),
        $this->stringClass()
      );
      $this->assertTrue($decl->isSubclassOf($this->objectClass()));
    }
  }
?>
