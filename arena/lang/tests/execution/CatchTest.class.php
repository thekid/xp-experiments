<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.execution';

  uses('tests.execution.ExecutionTest');

  /**
   * Tests arrays
   *
   */
  class tests·execution·CatchTest extends ExecutionTest {
    
    /**
     * Test try ... catch
     *
     */
    #[@test]
    public function catchNoException() {
      $this->assertEquals(array('Try'), $this->run('
        $r= [];
        try {
          $r[]= "Try";
        } catch (FormatException $e) {
          $r[]= "Catch";
        }
        return $r;
      '));
    }

    /**
     * Test try ... catch
     *
     */
    #[@test]
    public function catchWithException() {
      $this->assertEquals(array('Try', 'Catch'), $this->run('
        $r= [];
        try {
          $r[]= "Try";
          throw new FormatException("Error");
        } catch (FormatException $e) {
          $r[]= "Catch";
        }
        return $r;
      '));
    }

    /**
     * Test try ... catch ... catch
     *
     */
    #[@test]
    public function catchMultipleIAE() {
      $this->assertEquals(array('Try', 'lang.IllegalArgumentException'), $this->run('
        $r= [];
        try {
          $r[]= "Try";
          throw new IllegalArgumentException("Error");
        } catch (IllegalArgumentException $e) {
          $r[]= $e.getClassName();
        } catch (FormatException $e) {
          $r[]= $e.getClassName();
        }
        return $r;
      '));
    }

    /**
     * Test try ... catch ... catch
     *
     */
    #[@test]
    public function catchMultipleFE() {
      $this->assertEquals(array('Try', 'lang.FormatException'), $this->run('
        $r= [];
        try {
          $r[]= "Try";
          throw new FormatException("Error");
        } catch (IllegalArgumentException $e) {
          $r[]= $e.getClassName();
        } catch (FormatException $e) {
          $r[]= $e.getClassName();
        }
        return $r;
      '));
    }
  }
?>
