<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.execution.source';

  uses('tests.execution.source.ExecutionTest');

  /**
   * Tests arrays
   *
   */
  class tests·execution·source·AssignmentTest extends ExecutionTest {
    
    /**
     * Test assigning to a variable
     *
     */
    #[@test]
    public function assignToVariable() {
      $this->compile('$a= 1;');
    }

    /**
     * Test assigning to a member
     *
     */
    #[@test]
    public function assignToMember() {
      $this->compile('$this.i= 1;');
    }
    
    /**
     * Test assigning to an array offset
     *
     */
    #[@test]
    public function assignToArrayOffset() {
      $this->compile('$a= []; $a[0]= 1;');
    }

    /**
     * Test assigning to an array addition
     *
     */
    #[@test]
    public function assignToArrayAdd() {
      $this->compile('$a= []; $a[]= 1;');
    }

    /**
     * Test assigning to an array offset
     *
     */
    #[@test]
    public function assignToMemberArrayOffset() {
      $this->compile('$this.a= []; $this.a[0]= 1;');
    }

    /**
     * Test assigning to an array addition
     *
     */
    #[@test]
    public function assignToMemberArrayAdd() {
      $this->compile('$this.a= []; $this.a[]= 1;');
    }
    
    /**
     * Test assigning to a function call is not allowed
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function assignToFunction() {
      $this->compile('is()= 1;');
    }

    /**
     * Test assigning to a method call is not allowed
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function assignToMethod() {
      $this->compile('$this.equals()= 1;');
    }

    /**
     * Test assigning to a method call is not allowed
     *
     */
    #[@test]
    public function assignToMemberReturnedByMethod() {
      $this->compile('self::class.getMethod("equals").accessible= true;');
    }
  }
?>
