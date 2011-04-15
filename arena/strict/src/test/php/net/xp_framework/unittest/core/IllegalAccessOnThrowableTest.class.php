<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'net.xp_framework.unittest.core.IllegalAccessOnObjectTest'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class IllegalAccessOnThrowableTest extends IllegalAccessOnObjectTest {
    
    /**
     * Set up fixture
     *
     * @param   
     * @return  
     */
    public function setUp() {
      $this->poor= new Throwable('Some topic');
      $this->rich= newinstance('lang.Throwable', array('Some topic'), '{
        public $foo= NULL;
        public function foo() {}
      }');
    }
  }
?>
