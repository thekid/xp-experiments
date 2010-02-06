<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.execution.source';

  uses('tests.execution.source.ExecutionTest');

  /**
   * Tests chaining
   *
   */
  class tests·execution·source·ChainingTest extends ExecutionTest {
  
    /**
     * Test
     *
     */
    #[@test]
    public function parentOfTestClass() {
      $this->assertEquals(
        'lang.Object', 
        $this->run('return $this.getClass().getParentClass().getName();')
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function firstMethodOfTestClass() {
      $this->assertEquals(
        'run', 
        $this->run('return $this.getClass().getMethods()[0].getName();')
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function methodCallAfterNewObject() {
      $this->assertEquals(
        FALSE, 
        $this->run('return new Object().equals($this);')
      );
    }

    /**
     * Test
     *
     */
    #[@test, @ignore('Known limitation - array access does not work on Indexers')]
    public function arrayAccessAfterNew() {
      $this->assertEquals(
        6,
        $this->run('return new lang.types.ArrayList(5, 6, 7)[1];')
      );
    }

    /**
     * Test
     *
     */
    #[@test, @ignore('Known limitation - array access does not work on Indexers')]
    public function arrayAccessAfterStaticMethod() {
      $this->assertEquals(
        6,
        $this->run('return lang.types.ArrayList::newInstance([5, 6, 7])[1];')
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function arrayAccessAfterNewTypedArray() {
      $this->assertEquals(
        6,
        $this->run('return new int[]{5, 6, 7}[1];')
      );
    }


    /**
     * Test
     *
     */
    #[@test]
    public function memberAfterNewTypedArray() {
      $this->assertEquals(
        1, 
        $this->run('return new string[]{"Hello"}.length;')
      );
    }
  }
?>
