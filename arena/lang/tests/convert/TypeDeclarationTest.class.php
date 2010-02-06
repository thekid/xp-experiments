<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.convert';

  uses('tests.convert.AbstractConversionTest');

  /**
   * Tests type declarations
   *
   * @see      xp://tests.convert.AbstractConversionTest
   */
  class tests·convert·TypeDeclarationTest extends AbstractConversionTest {

    /**
     * Test
     *
     */
    #[@test]
    public function publicModifierAddedToClass() {
      $this->assertConversion(
        'public class Object { }',
        'class Object { }',
        SourceConverter::ST_NAMESPACE
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function publicModifierAddedToInterface() {
      $this->assertConversion(
        'public interface Runnable { }',
        'interface Runnable { }',
        SourceConverter::ST_NAMESPACE
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function fullyQualified() {
      $this->assertConversion(
        'public class Name { }',
        'class fully·qualified·Name { }',
        SourceConverter::ST_NAMESPACE
      );
    }
  }
?>
