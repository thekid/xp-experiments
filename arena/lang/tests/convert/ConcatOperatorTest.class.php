<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('tests.convert.AbstractConversionTest');

  /**
   * Tests the concat operator is rewritten
   *
   * @see      xp://tests.convert.AbstractConversionTest
   */
  class ConcatOperatorTest extends AbstractConversionTest {

    /**
     * Test
     *
     */
    #[@test]
    public function concatenation() {
      $this->assertConversion(
        '$a= "Hello" ~ "World";',
        '$a= "Hello"."World";',
        SourceConverter::ST_FUNC_BODY
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function notInsideStrings() {
      $this->assertConversion(
        '$a= "Hello" ~ "." ~ "World";',
        '$a= "Hello"."."."World";',
        SourceConverter::ST_FUNC_BODY
      );
    }
  }
?>
