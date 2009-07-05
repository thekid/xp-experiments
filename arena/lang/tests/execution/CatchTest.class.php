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
      $this->assertEquals(array('Try', 'Catch.IAE'), $this->run('
        $r= [];
        try {
          $r[]= "Try";
          throw new IllegalArgumentException("Error");
        } catch (IllegalArgumentException $e) {
          $r[]= "Catch.IAE";
        } catch (FormatException $e) {
          $r[]= "Catch.FE";
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
      $this->assertEquals(array('Try', 'Catch.FE'), $this->run('
        $r= [];
        try {
          $r[]= "Try";
          throw new FormatException("Error");
        } catch (IllegalArgumentException $e) {
          $r[]= "Catch.IAE";
        } catch (FormatException $e) {
          $r[]= "Catch.FE";
        }
        return $r;
      '));
    }
  }
?>
