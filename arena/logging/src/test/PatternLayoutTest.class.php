<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'util.log.PatternLayout'
  );

  /**
   * TestCase
   *
   * @see      xp://util.log.PatternLayout
   */
  class PatternLayoutTest extends TestCase {

    /**
     * Test illegal format token %Q
     * 
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function illegalFormatToken() {
      new PatternLayout('%Q');
    }
 
    /**
     * Test unterminated format token
     * 
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function unterminatedFormatToken() {
      new PatternLayout('%');
    }

    /**
     * Test simple format:
     * <pre>
     *    WARN [default] Hello
     * </pre>
     */
    #[@test]
    public function simpleFormat() {
      $this->assertEquals(
        'WARN [default] Hello',
        create(new PatternLayout('%L [%c] %m'))->format(new LoggingEvent(
          new LogCategory('default', NULL, NULL, 0), 
          1258733284, 
          1, 
          LogLevel::WARN, 
          'Hello'
        ))
      );
    }

    /**
     * Test default format:
     * <pre>
     *   [16:08:04 1214 info] Hello
     * </pre>
     */
    #[@test]
    public function defaultFormat() {
      $this->assertEquals(
        '[16:08:04 1214 info] Hello',
        create(new PatternLayout('[%t %p %l] %m'))->format(new LoggingEvent(
          new LogCategory('default', NULL, NULL, 0), 
          1258733284, 
          1214, 
          LogLevel::INFO, 
          'Hello'
        ))
      );
    }
  }
?>
