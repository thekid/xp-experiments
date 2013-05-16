<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'lang.types.String',
    'Lookup'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class LookupTest extends TestCase {
  
    /**
     * Test key lookup
     *
     */
    #[@test]
    public function get() {
      $l= create('new Lookup<lang.types.String>', array(
        'color'   => new String('green')
      ));
      $this->assertEquals(new String('green'), $l['color'], '[] overload');
      $this->assertEquals(new String('green'), $l->get('color'), 'get() method');
    }

    /**
     * Test testing keys
     *
     */
    #[@test]
    public function existanceTest() {
      $l= create('new Lookup<lang.types.String>', array(
        'color'   => new String('green')
      ));
      $this->assertTrue(isset($l['color']), 'existant');
      $this->assertFalse(isset($l['@@non-existant@@']), 'non-existant');
    }

    /**
     * Test looking up a non-existant key
     *
     */
    #[@test, @expect('lang.ElementNotFoundException')]
    public function getNonExistant() {
      $l= create('new Lookup<lang.types.String>', array(
        'color'   => new String('green')
      ));
      $l['@@non-existant@@'];
    }

    /**
     * Test creating an empty lookup-map
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function emptyLookup() {
      create('new Lookup<lang.types.String>', array());
    }

    /**
     * Test creating a non-generic lookup map
     *
     */
    #[@test]
    public function nonGeneric() {
      $this->assertEquals(
        new String('green'),
        create(new Lookup(array('color' => new String('green'))))->get('color')
      );
    }

    /**
     * Test creating a lookup map with wrong type
     *
     */
    #[@test, @expect('lang.ClassCastException')]
    public function lookupGenericTypeMismatch() {
      create('new Lookup<lang.types.String>', array(
        'color' => new Object()
      ));
    }

    /**
     * Test modifying a map
     *
     */
    #[@test, @expect('lang.IllegalStateException')]
    public function addingMember() {
      $l= create('new Lookup<lang.types.String>', array(
        'color'   => new String('green')
      ));
      $l['additional']= new String('red');
    }

    /**
     * Test modifying a map
     *
     */
    #[@test, @expect('lang.IllegalStateException')]
    public function removingMember() {
      $l= create('new Lookup<lang.types.String>', array(
        'color'   => new String('green')
      ));
      unset($l['color']);
    }
  }
?>
