<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('tests.convert.AbstractConversionTest');

  /**
   * Tests array syntax is rewritten
   *
   * @see      xp://tests.convert.AbstractConversionTest
   */
  class ArrayRewritingTest extends AbstractConversionTest {

    /**
     * Test
     *
     */
    #[@test]
    public function intArray() {
      $this->assertConversion(
        '$a= [1, 2, 3];',
        '$a= array(1, 2, 3);',
        SourceConverter::ST_FUNC_BODY
      );
    }
 
    /**
     * Test
     *
     */
    #[@test]
    public function stringArray() {
      $this->assertConversion(
        '$a= ["Hello", "World"];',
        '$a= array("Hello", "World");',
        SourceConverter::ST_FUNC_BODY
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function arrayOfArrays() {
      $this->assertConversion(
        '$a= [[1, 3], [2, 4]];',
        '$a= array(array(1, 3), array(2, 4));',
        SourceConverter::ST_FUNC_BODY
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function emptyArray() {
      $this->assertConversion(
        '$a= [];',
        '$a= array();',
        SourceConverter::ST_FUNC_BODY
      );
    }
  }
?>
