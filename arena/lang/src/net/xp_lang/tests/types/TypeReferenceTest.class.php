<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.types.TypeReference'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.types.TypeReference
   */
  class TypeReferenceTest extends TestCase {
  
    /**
     * Test name() method
     *
     */
    #[@test]
    public function nameWithoutPackage() {
      $decl= new TypeReference(new TypeName('TestCase'));
      $this->assertEquals('TestCase', $decl->name());
    }

    /**
     * Test name() method
     *
     */
    #[@test]
    public function literalWithoutPackage() {
      $decl= new TypeReference(new TypeName('TestCase'));
      $this->assertEquals('TestCase', $decl->literal());
    }

    /**
     * Test name() method
     *
     */
    #[@test]
    public function nameWithPackage() {
      $decl= new TypeReference(new TypeName('unittest.TestCase'));
      $this->assertEquals('unittest.TestCase', $decl->name());
    }

    /**
     * Test name() method
     *
     */
    #[@test]
    public function literalWithPackage() {
      $decl= new TypeReference(new TypeName('unittest.TestCase'));
      $this->assertEquals('TestCase', $decl->literal());
    }
  }
?>
