<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'com.thoughtworks.selenium.Selenium'
  );

  /**
   * TestCase
   *
   * @see      http://seleniumhq.org
   * @purpose  test case
   */
  class SeleniumTest extends TestCase {
    protected static
      $selenium = NULL;

    /**
     * Setup
     *
     */
    #[@beforeClass]
    public static function startSelenium() {
      self::$selenium= new Selenium('*firefox', 'http://google.de');
      self::$selenium->start();
    }

    /**
     * Teardown
     *
     */
    #[@afterClass]
    public static function stopSelenium() {
      self::$selenium->close();
      self::$selenium->stop();
    }

    /**
     * Test
     *
     */
    #[@test]
    public function openPage() {
      $this->assertNull(self::$selenium->open('/'));
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */


  }
?>
