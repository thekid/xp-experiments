<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.convert.AbstractConversionTest');

  /**
   * Tests import native statements are created
   *
   * @see      xp://tests.convert.AbstractConversionTest
   */
  class NativeImportsForFunctionsTest extends AbstractConversionTest {

    /**
     * Test
     *
     */
    #[@test]
    public function sprintf() {
      $this->assertConversion(
        "import native standard.sprintf;\n\n".
        "public class String { public void format() { return sprintf(); }}",
        'class String { public function format() { return sprintf(); }}',
        SourceConverter::ST_NAMESPACE
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function preg_replace() {
      $this->assertConversion(
        "import native pcre.preg_replace;\n\n".
        "public class String { public void replace() { return preg_replace(); }}",
        'class String { public function replace() { return preg_replace(); }}',
        SourceConverter::ST_NAMESPACE
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function strlen() {
      $this->assertConversion(
        "import native core.strlen;\n\n".
        "public class String { public void length() { return strlen(); }}",
        'class String { public function length() { return strlen(); }}',
        SourceConverter::ST_NAMESPACE
      );
    }
  }
?>
