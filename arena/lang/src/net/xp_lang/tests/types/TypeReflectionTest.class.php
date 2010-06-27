<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.types.TypeReflection'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.types.TypeReflection
   */
  class TypeReflectionTest extends TestCase {
  
    /**
     * Test name() method
     *
     */
    #[@test]
    public function name() {
      $decl= new TypeReflection(XPClass::forName('unittest.TestCase'));
      $this->assertEquals('unittest.TestCase', $decl->name());
    }

    /**
     * Test literal() method
     *
     */
    #[@test]
    public function literal() {
      $decl= new TypeReflection(XPClass::forName('unittest.TestCase'));
      $this->assertEquals('TestCase', $decl->literal());
    }

    /**
     * Test hasMethod() method
     *
     */
    #[@test]
    public function objectClassHasMethod() {
      $decl= new TypeReflection(XPClass::forName('lang.Object'));
      $this->assertTrue($decl->hasMethod('equals'), 'equals');
      $this->assertFalse($decl->hasMethod('getName'), 'getName');
    }

    /**
     * Test hasConstructor() method
     *
     */
    #[@test]
    public function objectClassHasNoConstructor() {
      $decl= new TypeReflection(XPClass::forName('lang.Object'));
      $this->assertFalse($decl->hasConstructor());
    }

    /**
     * Test getConstructor() method
     *
     */
    #[@test]
    public function objectClassNoConstructor() {
      $decl= new TypeReflection(XPClass::forName('lang.Object'));
      $this->assertNull($decl->getConstructor());
    }

    /**
     * Test hasConstructor() method
     *
     */
    #[@test]
    public function testCaseClassHasConstructor() {
      $decl= new TypeReflection(XPClass::forName('unittest.TestCase'));
      $this->assertTrue($decl->hasConstructor());
    }

    /**
     * Test getConstructor() method
     *
     */
    #[@test]
    public function testCaseClassConstructor() {
      $decl= new TypeReflection(XPClass::forName('unittest.TestCase'));
      $this->assertInstanceOf('xp.compiler.types.Constructor', $decl->getConstructor());
    }

    /**
     * Test kind() method
     *
     */
    #[@test]
    public function classKind() {
      $decl= new TypeReflection(XPClass::forName('lang.Object'));
      $this->assertEquals(Types::CLASS_KIND, $decl->kind());
    }

    /**
     * Test kind() method
     *
     */
    #[@test]
    public function interfaceKind() {
      $decl= new TypeReflection(XPClass::forName('lang.Generic'));
      $this->assertEquals(Types::INTERFACE_KIND, $decl->kind());
    }

    /**
     * Test hasMethod() method
     *
     */
    #[@test]
    public function stringClassHasMethod() {
      $decl= new TypeReflection(XPClass::forName('lang.types.String'));
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
      $decl= new TypeReflection(XPClass::forName('lang.types.String'));
      $this->assertTrue($decl->hasIndexer());
    }

    /**
     * Test hasIndexer() method
     *
     */
    #[@test]
    public function objectClassDoesNotHaveIndexer() {
      $decl= new TypeReflection(XPClass::forName('lang.Object'));
      $this->assertFalse($decl->hasIndexer());
    }

    /**
     * Test getIndexer() method
     *
     */
    #[@test]
    public function stringClassIndexer() {
      $indexer= create(new TypeReflection(XPClass::forName('lang.types.String')))->getIndexer();
      $this->assertEquals(new TypeName('lang.types.Character'), $indexer->type);
      $this->assertEquals(array(new TypeName('int')), $indexer->parameters);
    }

    /**
     * Test hasConstant() method
     *
     */
    #[@test]
    public function objectClassDoesNotHaveConstant() {
      $decl= new TypeReflection(XPClass::forName('lang.Object'));
      $this->assertFalse($decl->hasConstant('STATUS_OK'));
    }

    /**
     * Test hasConstant() method
     *
     */
    #[@test]
    public function httpConstantsClassDoesNotHaveConstant() {
      $decl= new TypeReflection(XPClass::forName('peer.http.HttpConstants'));
      $this->assertTrue($decl->hasConstant('STATUS_OK'));
    }

    /**
     * Test hasConstant() method
     *
     */
    #[@test]
    public function httpConstantsConstant() {
      $const= create(new TypeReflection(XPClass::forName('peer.http.HttpConstants')))->getConstant('STATUS_OK');
      $this->assertEquals(200, $const->value);
    }

    /**
     * Test isEnumerable() method
     *
     */
    #[@test]
    public function objectClassIsNotEnumerable() {
      $decl= new TypeReflection(XPClass::forName('lang.Object'));
      $this->assertFalse($decl->isEnumerable());
    }

    /**
     * Test getEnumerator() method
     *
     */
    #[@test]
    public function arrayListClassEnumerator() {
      $enum= create(new TypeReflection(XPClass::forName('lang.types.ArrayList')))->getEnumerator();
      $this->assertEquals(new TypeName('int'), $enum->key);
      $this->assertEquals(new TypeName('var'), $enum->value);
    }
  }
?>
