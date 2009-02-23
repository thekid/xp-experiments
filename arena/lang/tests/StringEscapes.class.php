<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.emit.Strings'
  );

  /**
   * TestCase
   *
   * @see   xp://xp.compiler.emit.Strings
   */
  class StringEscapes extends TestCase {

    /**
     * Fail this test case
     *
     * @param   string reason
     * @param   mixed actual
     * @param   mixed expect
     */
    public function fail($reason, $actual, $expect) {
      is_string($actual) && $actual= addcslashes($actual, "\0..\17");
      is_string($expect) && $expect= addcslashes($expect, "\0..\17");
      parent::fail($reason, $actual, $expect);
    }

    /**
     * Test "\n"
     *
     */
    #[@test]
    public function newLine() {
      $this->assertEquals("Hello\nWorld", Strings::expandEscapesIn('Hello\nWorld'));
    }
    
    /**
     * Test "\ü" is not a legal escape sequence
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function illegal() {
      Strings::expandEscapesIn('\ü');
    }

    /**
     * Test "\r"
     *
     */
    #[@test]
    public function carriageReturn() {
      $this->assertEquals("Hello\rWorld", Strings::expandEscapesIn('Hello\rWorld'));
    }

    /**
     * Test "\t"
     *
     */
    #[@test]
    public function tab() {
      $this->assertEquals("Hello\tWorld", Strings::expandEscapesIn('Hello\tWorld'));
    }

    /**
     * Test "\\"
     *
     */
    #[@test]
    public function backslash() {
      $this->assertEquals('Hello\\World', Strings::expandEscapesIn('Hello\\\\World'));
    }

    /**
     * Test a backslash at the beginning
     *
     */
    #[@test]
    public function leadingBackslash() {
      $this->assertEquals('\\Hello', Strings::expandEscapesIn('\\\\Hello'));
    }

    /**
     * Test a backslash at the end
     *
     */
    #[@test]
    public function trailingBackslash() {
      $this->assertEquals('Hello\\', Strings::expandEscapesIn('Hello\\\\'));
    }
  }
?>
