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
  class AnnotationConversionTest extends AbstractConversionTest {

    /**
     * Test simple "test" annotations
     *
     */
    #[@test]
    public function testAnnotation() {
      $this->assertConversion(
        "[@test]\npublic void test() { /* ... */ }",
        "#[@test]\npublic function test() { /* ... */ }",
        SourceConverter::ST_DECL
      );
    }
  }
?>
