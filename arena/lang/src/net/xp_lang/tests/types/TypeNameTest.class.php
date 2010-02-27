<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.types.TypeName'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.types.TypeName
   */
  class TypeNameTest extends TestCase {

    /**
     * Test isVariable()
     *
     */
    #[@test]
    public function varIsVariable() {
      $this->assertTrue(create(new TypeName('var'))->isVariable());
    }

    /**
     * Test isVariable()
     *
     */
    #[@test]
    public function voidIsNotVariable() {
      $this->assertFalse(create(new TypeName('void'))->isVariable());
    }

    /**
     * Test isVariable()
     *
     */
    #[@test]
    public function objectIsNotVariable() {
      $this->assertFalse(create(new TypeName('lang.Object'))->isVariable());
    }

    /**
     * Test isVoid()
     *
     */
    #[@test]
    public function varIsNotVoid() {
      $this->assertFalse(create(new TypeName('var'))->isVoid());
    }

    /**
     * Test isVoid()
     *
     */
    #[@test]
    public function voidIsVoid() {
      $this->assertTrue(create(new TypeName('void'))->isVoid());
    }

    /**
     * Test isVoid()
     *
     */
    #[@test]
    public function objectIsNotVoid() {
      $this->assertFalse(create(new TypeName('lang.Object'))->isVoid());
    }

    /**
     * Test isPrimitive()
     *
     */
    #[@test]
    public function intIsPrimitive() {
      $this->assertTrue(create(new TypeName('int'))->isPrimitive());
    }

    /**
     * Test isPrimitive()
     *
     */
    #[@test]
    public function objectIsNotPrimitive() {
      $this->assertFalse(create(new TypeName('lang.Object'))->isPrimitive());
    }

    /**
     * Test isArray()
     *
     */
    #[@test]
    public function intArrayIsArray() {
      $this->assertTrue(create(new TypeName('int[]'))->isArray());
    }

    /**
     * Test isArray()
     *
     */
    #[@test]
    public function intIsNotArray() {
      $this->assertFalse(create(new TypeName('int'))->isArray());
    }

    /**
     * Test isMap()
     *
     */
    #[@test]
    public function intIntMapIsMap() {
      $this->assertTrue(create(new TypeName('[int:int]'))->isMap());
    }

    /**
     * Test isMap()
     *
     */
    #[@test]
    public function intIsNotMap() {
      $this->assertFalse(create(new TypeName('int'))->isMap());
    }

    /**
     * Test isMap()
     *
     */
    #[@test]
    public function intArrayIsNotMap() {
      $this->assertFalse(create(new TypeName('int[]'))->isMap());
    }

    /**
     * Test isGeneric()
     *
     */
    #[@test]
    public function genericListIsGeneric() {
      $this->assertTrue(create(new TypeName('List', array(new TypeName('T'))))->isGeneric());
    }

    /**
     * Test isGeneric()
     *
     */
    #[@test]
    public function arrayIsNotGeneric() {
      $this->assertFalse(create(new TypeName('T[]'))->isGeneric());
    }
  
    /**
     * Test compoundName()
     *
     */
    #[@test]
    public function intPrimitiveCompoundName() {
      $this->assertEquals('int', create(new TypeName('int'))->compoundName());
    }

    /**
     * Test compoundName()
     *
     */
    #[@test]
    public function stringArrayCompoundName() {
      $this->assertEquals('string[]', create(new TypeName('string[]'))->compoundName());
    }

    /**
     * Test compoundName()
     *
     */
    #[@test]
    public function objectClassCompoundName() {
      $this->assertEquals('lang.Object', create(new TypeName('lang.Object'))->compoundName());
    }

    /**
     * Test compoundName()
     *
     */
    #[@test]
    public function genericListCompoundName() {
      $this->assertEquals('List<T>', create(new TypeName('List', array(new TypeName('T'))))->compoundName());
    }

    /**
     * Test arrayComponentType()
     *
     */
    #[@test]
    public function arrayComponentType() {
      $this->assertEquals(new TypeName('string'), create(new TypeName('string[]'))->arrayComponentType());
    }

    /**
     * Test arrayComponentType()
     *
     */
    #[@test]
    public function arrayComponentTypeOfNonArray() {
      $this->assertEquals(NULL, create(new TypeName('string'))->arrayComponentType());
    }
  }
?>
