<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.ide.unittest.TestCase',
    'xp.ide.XpIde',
    'xp.ide.streams.EncodedInputStreamWrapper',
    'xp.ide.streams.EncodedOutputStreamWrapper',
    'io.streams.MemoryInputStream',
    'io.streams.MemoryOutputStream'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class XpIdeTest extends xp·ide·unittest·TestCase {
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
      $this->ide= new xp·ide·XpIde(
        $this->in= new xp·ide·streams·EncodedInputStreamWrapper(new MemoryInputStream('')),
        $this->out= new xp·ide·streams·EncodedOutputStreamWrapper(new MemoryOutputStream()),
        $this->err= new xp·ide·streams·EncodedOutputStreamWrapper(new MemoryOutputStream())
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function testComplete() {
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorsEmpty() {
      $this->ide->createAccessors();
      $this->assertEquals('', $this->ide->getOut()->getStream()->getBytes());
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorsSetOne() {
      $this->ide->getIn()->setStream(new MemoryInputStream('in:string:set'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createSetter('in', 'string'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorsSetTwo() {
      $this->ide->getIn()->setStream(new MemoryInputStream('in:string:set'."\n".'out:string:set'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createSetter('in', 'string').PHP_EOL.
        $this->createSetter('out', 'string'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * create a setter
     *
     * @param string name
     * @param string type
     */
    private function createSetter($name, $type) {
      return sprintf(
        '    /**'.PHP_EOL.
        '     * set member $%1$s'.PHP_EOL.
        '     *'.PHP_EOL.
        '     * @param %3s %1$s'.PHP_EOL.
        '     */'.PHP_EOL.
        '    public function set%2$s($%1$s) {'.PHP_EOL.
        '      $this->%1$s= $%1$s;'.PHP_EOL.
        '    }'.PHP_EOL,
        $name, ucfirst($name), $type
      );
    }

  }
?>
