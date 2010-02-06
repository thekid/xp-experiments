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
     * Test with() with one parameter
     *
     */
    #[@test]
    public function withOne() {
      $this->assertConversion(
        'with ($a= new Node("root")) { $a.setContent($c); }',
        'with ($a= new Node("root")); { $a->setContent($c); }',
        SourceConverter::ST_FUNC_BODY
      );
    }

    /**
     * Test with() with more than one parameter
     *
     */
    #[@test]
    public function withMore() {
      $this->assertConversion(
        'with ($a= new Node("root"), $b= $a.addChild("doc")) { $b.setContent($c); }',
        'with ($a= new Node("root"), $b= $a->addChild("doc")); { $b->setContent($c); }',
        SourceConverter::ST_FUNC_BODY
      );
    }
  }
?>
