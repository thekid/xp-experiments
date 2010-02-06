<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.convert.AbstractConversionTest');

  /**
   * Tests foreach
   *
   * @see      xp://tests.convert.AbstractConversionTest
   */
  class ForeachConversionTest extends AbstractConversionTest {

    /**
     * Test
     *
     */
    #[@test]
    public function asValue() {
      $this->assertConversion(
        'foreach ($v in $a) { /* ... */ }',
        'foreach ($a as $v) { /* ... */ }',
        SourceConverter::ST_FUNC_BODY
      );
    }
  }
?>
