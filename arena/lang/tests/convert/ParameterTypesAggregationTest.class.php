<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.convert.AbstractConversionTest');

  /**
   * Tests parameter types
   *
   * @see      xp://tests.convert.AbstractConversionTest
   */
  class ParameterTypesAggregationTest extends AbstractConversionTest {

    /**
     * Test no parameter types
     *
     */
    #[@test]
    public function noParameterTypes() {
      $this->assertConversion(
        "public void test(var \$a) { /* ... */ }",
        "public function test(\$a) { /* ... */ }",
        SourceConverter::ST_DECL
      );
    }

    /**
     * Test string parameter type
     *
     */
    #[@test]
    public function stringParameterType() {
      $this->assertConversion(
        "/**\n".
        " * @param   string a\n".
        " */\n".
        "public string test(string \$a) { /* ... */ }",
        "/**\n".
        " * @param   string a\n".
        " */\n".
        "public function test(\$a) { /* ... */ }",
        SourceConverter::ST_DECL
      );
    }
  }
?>
