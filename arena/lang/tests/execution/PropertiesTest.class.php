<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.execution';

  uses('tests.execution.ExecutionTest');

  /**
   * Tests properties
   *
   */
  class tests·execution·PropertiesTest extends ExecutionTest {
    protected $fixture= NULL;


    /**
     * Sets up test case
     *
     */
    public function setUp() {
      parent::setUp();
      $this->fixture= $this->define('class', 'StringBufferFor'.$this->name, '{
        protected string $buffer;
        
        public __construct(string $initial) {
          $this.buffer= $initial;
        }
        
        public int length {
          get { return strlen($this.buffer); }
          set { throw new lang.IllegalAccessException("Cannot set string length"); }
        }

        public string[] chars {
          get { return str_split($this.buffer); }
          set { $this.buffer= implode("", $value); }
        }
        
        public string toString() {
          return $this.buffer;
        }
      }', array(
        'import native zend.strlen;', 
        'import native standard.str_split;',
        'import native standard.implode;',
      ));
    }
    
    /**
     * Test reading the length property
     *
     */
    #[@test]
    public function readLength() {
      $str= $this->fixture->newInstance('Hello');
      $this->assertEquals(5, $str->length);
    }

    /**
     * Test reading the chars property
     *
     */
    #[@test]
    public function readChars() {
      $str= $this->fixture->newInstance('Hello');
      $this->assertEquals(array('H', 'e', 'l', 'l', 'o'), $str->chars);
    }

    /**
     * Test writing the length property
     *
     */
    #[@test, @expect('lang.IllegalAccessException')]
    public function writeLength() {
      $str= $this->fixture->newInstance('Hello');
      $str->length= 5;
    }

    /**
     * Test writing the chars property
     *
     */
    #[@test]
    public function writeChars() {
      $str= $this->fixture->newInstance('Hello');
      $str->chars= array('A', 'B', 'C');
      $this->assertEquals('ABC', $str->toString());
    }
  }
?>
