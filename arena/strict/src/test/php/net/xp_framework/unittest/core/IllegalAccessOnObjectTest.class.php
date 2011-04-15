<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class IllegalAccessOnObjectTest extends TestCase {
    protected
      $rich = NULL,
      $poor = NULL;
    
    /**
     * Set up fixture
     *
     * @param   
     * @return  
     */
    public function setUp() {
      $this->poor= new Object();
      $this->rich= newinstance('lang.Object', array(), '{
        public $foo= NULL;
        public function foo() {}
      }');
    }
  
    /**
     * Test valid get
     *
     */
    #[@test]
    public function testValidGet() {
      $this->rich->foo;
    }

    /**
     * Test invalid get throws lang.Error
     *
     */
    #[@test, @expect('lang.Error')]
    public function testInvalidGet() {
      $this->poor->foo;
    }
    
  
    /**
     * Test valid set
     *
     */
    #[@test]
    public function testValidSet() {
      $this->rich->foo= 'bar';
    }

    /**
     * Test invalid write throws lang.Error
     *
     */
    #[@test, @expect('lang.Error')]
    public function testInvalidSet() {
      $this->poor->foo= 'bar';
    }
    
    /**
     * Test valid call
     *
     */
    #[@test]
    public function testValidCall() {
      $this->rich->foo();
    }
    
    /**
     * Test invalid call throws lang.Error
     *
     */
    #[@test, @expect('lang.Error')]
    public function testInvalidCall() {
      $this->poor->foo();
    }
  }
?>
