<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.convert.AbstractConversionTest');

  /**
   * Tests with
   *
   * @see      xp://tests.convert.AbstractConversionTest
   */
  class WithConversionTest extends AbstractConversionTest {

    /**
     * Test NULL
     *
     */
    #[@test]
    public function syntaxRewritten() {
      $this->assertConversion(
        'with ($a= new Node("root")) { $a.setContent($c); }',
        'with ($a= new Node("root")); { $a->setContent($c); }',
        SourceConverter::ST_FUNC_BODY
      );
    }

  }
?>
