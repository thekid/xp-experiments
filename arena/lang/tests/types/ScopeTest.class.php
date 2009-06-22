<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.types.Scope',
    'xp.compiler.emit.TypeReflection',
    'xp.compiler.ast.VariableNode'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.types.Scope
   */
  class ScopeTest extends TestCase {
    protected $fixture= NULL;
    
    /**
     * Sets up this testcase
     *
     */
    public function setUp() {
      $this->fixture= new Scope();
    }
    
    /**
     * Test typeOf() method
     *
     */
    #[@test]
    public function arrayType() {
      $this->assertEquals(new TypeName('var[]'), $this->fixture->typeOf(new ArrayNode()));
    }
    
    /**
     * Test typeOf() method
     *
     */
    #[@test]
    public function mapType() {
      $this->assertEquals(new TypeName('[var:var]'), $this->fixture->typeOf(new MapNode()));
    }
    
    /**
     * Test typeOf() method
     *
     */
    #[@test]
    public function stringType() {
      $this->assertEquals(new TypeName('string'), $this->fixture->typeOf(new StringNode()));
    }
    
    /**
     * Test typeOf() method
     *
     */
    #[@test]
    public function intType() {
      $this->assertEquals(new TypeName('int'), $this->fixture->typeOf(new IntegerNode()));
    }
    
    /**
     * Test typeOf() method
     *
     */
    #[@test]
    public function hexType() {
      $this->assertEquals(new TypeName('int'), $this->fixture->typeOf(new HexNode()));
    }
    
    /**
     * Test typeOf() method
     *
     */
    #[@test]
    public function decimalType() {
      $this->assertEquals(new TypeName('double'), $this->fixture->typeOf(new DecimalNode()));
    }
    
    /**
     * Test typeOf() method
     *
     */
    #[@test]
    public function nullType() {
      $this->assertEquals(new TypeName('lang.Object'), $this->fixture->typeOf(new NullNode()));
    }
    
    /**
     * Test typeOf() method
     *
     */
    #[@test]
    public function boolType() {
      $this->assertEquals(new TypeName('bool'), $this->fixture->typeOf(new BooleanNode()));
    }
    
    /**
     * Test typeOf() method
     *
     */
    #[@test]
    public function typeOfAComparison() {
      $this->assertEquals(new TypeName('bool'), $this->fixture->typeOf(new ComparisonNode()));
    }

    /**
     * Test setType() and typeOf() methods
     *
     */
    #[@test]
    public function registeredType() {
      with ($v= new VariableNode('h'), $t= new TypeName('util.collections.HashTable')); {
        $this->fixture->setType($v, $t);
        $this->assertEquals($t, $this->fixture->typeOf($v));
      }
    }

    /**
     * Test typeOf() method
     *
     */
    #[@test]
    public function unknownType() {
      $this->assertEquals(TypeName::$VAR, $this->fixture->typeOf(new VariableNode('v')));
    }

    /**
     * Test extension method API
     *
     */
    #[@test]
    public function objectExtension() {
      with (
        $objectType= new TypeReflection(XPClass::forName('lang.Object')), 
        $classNameMethod= new xp·compiler·emit·Method('getClassName')
      ); {
        $this->fixture->addExtension($objectType, $classNameMethod, 'lang.ext.ObjectExtension');
        $this->assertTrue($this->fixture->hasExtension($objectType, $classNameMethod->name));
        $this->assertEquals(
          $classNameMethod,
          $this->fixture->getExtension($objectType, $classNameMethod->name)
        );
      }
    }

    /**
     * Test extension method API
     *
     */
    #[@test]
    public function objectExtensionInherited() {
      with (
        $objectType= new TypeReflection(XPClass::forName('lang.Object')), 
        $dateType= new TypeReflection(XPClass::forName('util.Date')),
        $classNameMethod= new xp·compiler·emit·Method('getClassName')
      ); {
        $this->fixture->addExtension($objectType, $classNameMethod, 'lang.ext.ObjectExtension');
        $this->assertTrue($this->fixture->hasExtension($dateType, $classNameMethod->name));
        $this->assertEquals(
          $classNameMethod,
          $this->fixture->getExtension($dateType, $classNameMethod->name)
        );
      }
    }
  }
?>
