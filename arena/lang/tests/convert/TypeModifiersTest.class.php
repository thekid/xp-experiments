<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.convert.AbstractConversionTest');

  /**
   * Tests type modifiers
   *
   * @see      xp://tests.convert.AbstractConversionTest
   */
  class TypeModifiersTest extends AbstractConversionTest {

    /**
     * Test
     *
     */
    #[@test]
    public function classType() {
      $this->assertConversion(
        'public class String { }',
        'class String { }',
        SourceConverter::ST_NAMESPACE
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function interfaceType() {
      $this->assertConversion(
        'public interface Runnable { }',
        'interface Runnable { }',
        SourceConverter::ST_NAMESPACE
      );
    }
  }
?>
