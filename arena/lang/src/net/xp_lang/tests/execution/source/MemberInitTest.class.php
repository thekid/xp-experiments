<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'net.xp_lang.tests.execution.source';

  uses('net.xp_lang.tests.execution.source.ExecutionTest');

  /**
   * Tests member initialization
   *
   */
  class net·xp_lang·tests·execution·source·MemberInitTest extends ExecutionTest {
  
    /**
     * Creates a new instance
     *
     * @param   string src
     * @return  lang.Generic
     */
    protected function newInstance($src) {
      return $this->define('class', $this->getName(), NULL, $src)->newInstance();
    }
  
    /**
     * Test member initialized to an empty array
     *
     */
    #[@test]
    public function toEmptyArray() {
      $this->assertEquals(array(), $class->newInstance('{ public Object[] $images= []; }')->images);
    }

    /**
     * Test member initialized to an empty string
     *
     */
    #[@test]
    public function toNonEmptyString() {
      $this->assertEquals('Name', $class->newInstance('{ public string $name= "Name"; }')->name);
    }

    /**
     * Test member initialized to an empty string
     *
     */
    #[@test]
    public function toEmptyString() {
      $this->assertEquals('', $class->newInstance('{ public string $name= ""; }')->name);
    }

    /**
     * Test member initialized to an empty string
     *
     */
    #[@test]
    public function toNull() {
      $this->assertNull($class->newInstance('{ public string $name= null; }')->name);
    }
  }
?>
