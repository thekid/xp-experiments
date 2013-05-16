<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'util.collections.EnumLookup'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class EnumLookupTest extends TestCase {
  
    /**
     * Test
     *
     */
    #[@test]
    public function penny() {
      $l= new EnumLookup(XPClass::forName('examples.coin.Coin'));
      $this->assertEquals(Coin::$penny, $l->get('penny'));
      $this->assertEquals(Coin::$penny, $l->get(1));
      $this->assertEquals(Coin::$penny, $l['penny']);
      $this->assertEquals(Coin::$penny, $l[1]);
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.ElementNotFoundException')]
    public function nonExistantMember() {
      $l= new EnumLookup(XPClass::forName('examples.coin.Coin'));
      $l->get('dollar');
    }
  }
?>
