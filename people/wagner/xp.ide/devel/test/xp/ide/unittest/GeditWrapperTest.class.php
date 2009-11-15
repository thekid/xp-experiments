<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.ide.wrapper.Gedit',
    'xp.ide.AccessorConfig',
    'xp.ide.unittest.TestCase',
    'xp.ide.unittest.mock.XpIde',
    'io.streams.TextReader',
    'io.streams.TextWriter',
    'io.streams.MemoryInputStream',
    'io.streams.MemoryOutputStream'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class GeditWrapperTest extends xp·ide·unittest·TestCase {
    private
      $ide= NULL,
      $in=  NULL,
      $out= NULL,
      $err= NULL;

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->ide= new xp·ide·unittest·mock·XpIde(
        $this->in= new TextReader(new MemoryInputStream('')),
        $this->out= new TextWriter(new MemoryOutputStream()),
        $this->err= new TextWriter(new MemoryOutputStream())
      );
      $this->wrapper= new xp·ide·wrapper·Gedit($this->ide);
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorSetterGetterTwo() {
      $this->setInput('in:integer:::get+set'.PHP_EOL.'number:integer:::get+set');
      $this->wrapper->createAccessors();

      $conf= array(
        new xp·ide·AccessorConfig('in', 'integer'),
        new xp·ide·AccessorConfig('number', 'integer'),
      );
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[1]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $conf[1]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $this->assertEquals($conf, $this->ide->getAccessorConfig());
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorGetterTwo() {
      $this->setInput('in:integer:::get'.PHP_EOL.'number:integer:::get');
      $this->wrapper->createAccessors();

      $conf= array(
        new xp·ide·AccessorConfig('in', 'integer'),
        new xp·ide·AccessorConfig('number', 'integer'),
      );
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $conf[1]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->assertEquals($conf, $this->ide->getAccessorConfig());
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorSetterTwo() {
      $this->setInput('in:integer:::set'.PHP_EOL.'number:integer:::set');
      $this->wrapper->createAccessors();

      $conf= array(
        new xp·ide·AccessorConfig('in', 'integer'),
        new xp·ide·AccessorConfig('number', 'integer'),
      );
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[1]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $this->assertEquals($conf, $this->ide->getAccessorConfig());
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorSetterOne() {
      $this->setInput('in:integer:::set');
      $this->wrapper->createAccessors();

      $conf= array(new xp·ide·AccessorConfig('in', 'integer'));
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $this->assertEquals($conf, $this->ide->getAccessorConfig());
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorNone() {
      $this->setInput('in:integer:::');
      $this->wrapper->createAccessors();
      $this->assertEquals(array(
        new xp·ide·AccessorConfig('in', 'integer'),
      ), $this->ide->getAccessorConfig());
    }

    /**
     * Test ide class
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function createAccessorLessFields() {
      $this->setInput('in:integer::');
      $this->wrapper->createAccessors();
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorEmpty() {
      $this->wrapper->createAccessors();
      $this->assertEquals(array(), $this->ide->getAccessorConfig());
    }

    /**
     * prepare input stream
     *
     * param string input
     */
    private function setInput($input) {
      $this->in= new TextReader(new MemoryInputStream($input));
      $this->wrapper->setIn($this->in);
    }
  }
?>
