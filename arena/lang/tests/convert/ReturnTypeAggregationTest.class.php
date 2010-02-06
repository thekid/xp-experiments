<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.convert.AbstractConversionTest');

  /**
   * Tests annotations
   *
   * @see      xp://tests.convert.AbstractConversionTest
   */
  class ReturnTypeAggregationTest extends AbstractConversionTest {

    /**
     * Test void return tpe
     *
     */
    #[@test]
    public function noReturnType() {
      $this->assertConversion(
        "public void test() { /* ... */ }",
        "public function test() { /* ... */ }",
        SourceConverter::ST_DECL
      );
    }

    /**
     * Test string return tpe
     *
     */
    #[@test]
    public function stringReturnType() {
      $this->assertConversion(
        "/**\n".
        " * @return  string\n".
        " */\n".
        "public string test() { /* ... */ }",
        "/**\n".
        " * @return  string\n".
        " */\n".
        "public function test() { /* ... */ }",
        SourceConverter::ST_DECL
      );
    }
  }
?>
