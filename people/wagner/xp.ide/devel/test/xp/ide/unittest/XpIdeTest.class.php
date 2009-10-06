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
    #[@test, @expect('lang.IllegalArgumentException')]
    public function createAccessorsNoSet() {
      $this->ide->getIn()->setStream(new MemoryInputStream('in:string'));
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
    public function createSettterOne() {
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
    public function createSetterTwo() {
      $this->ide->getIn()->setStream(new MemoryInputStream('in:string:set'."\n".'out:string:set'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createSetter('in', 'string').
        $this->createSetter('out', 'string'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createGetterOne() {
      $this->ide->getIn()->setStream(new MemoryInputStream('in:string:get'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createGetter('in', 'string'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createGetterTwo() {
      $this->ide->getIn()->setStream(new MemoryInputStream('in:string:get'."\n".'out:string:get'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createGetter('in', 'string').
        $this->createGetter('out', 'string'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterOne() {
      $this->ide->getIn()->setStream(new MemoryInputStream('in:string:set+get'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createSetter('in', 'string').
        $this->createGetter('in', 'string'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterTwo() {
      $this->ide->getIn()->setStream(new MemoryInputStream('in:string:set+get'.PHP_EOL.'out:string:set+get'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createSetter('in', 'string').
        $this->createGetter('in', 'string').
        $this->createSetter('out', 'string').
        $this->createGetter('out', 'string'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterInt() {
      $this->ide->getIn()->setStream(new MemoryInputStream('count:integer:set+get'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createSetter('count', 'integer').
        $this->createGetter('count', 'integer'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterBool() {
      $this->ide->getIn()->setStream(new MemoryInputStream('final:boolean:set+get'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createSetter('final', 'boolean').
        $this->createGetter('final', 'boolean'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterObject() {
      $this->ide->getIn()->setStream(new MemoryInputStream('root:lang.Object:set+get'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createSetter('root', 'lang.Object', 'Object').
        $this->createGetter('root', 'lang.Object'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterNamespaceObject() {
      $this->ide->getIn()->setStream(new MemoryInputStream('ide:xp.ide.XpIde:set+get'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createSetter('ide', 'xp.ide.XpIde', 'xp·ide·XpIde').
        $this->createGetter('ide', 'xp.ide.XpIde'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterArray() {
      $this->ide->getIn()->setStream(new MemoryInputStream('names:array:set+get'));
      $this->ide->createAccessors();
      $this->assertEquals(
        $this->createSetter('names', 'array', 'array').
        $this->createGetter('names', 'array'),
        $this->ide->getOut()->getStream()->getBytes()
      );
    }

    /**
     * create a setter
     *
     * @param string name
     * @param string type
     * @param string hint
     */
    private function createSetter($name, $type, $hint= '') {
      return sprintf(
        '    /**'.PHP_EOL.
        '     * set member $%1$s'.PHP_EOL.
        '     * '.PHP_EOL.
        '     * @param %3$s %1$s'.PHP_EOL.
        '     */'.PHP_EOL.
        '    public function set%2$s('.($hint ? '%4$s ' : '').'$%1$s) {'.PHP_EOL.
        '      $this->%1$s= $%1$s;'.PHP_EOL.
        '    }'.PHP_EOL.PHP_EOL,
        $name, ucfirst($name), $type, $hint
      );
    }

    /**
     * create a getter
     *
     * @param string name
     * @param string type
     */
    private function createGetter($name, $type) {
      return sprintf(
        '    /**'.PHP_EOL.
        '     * get member $%1$s'.PHP_EOL.
        '     * '.PHP_EOL.
        '     * @return %3$s'.PHP_EOL.
        '     */'.PHP_EOL.
        '    public function %4$s%2$s() {'.PHP_EOL.
        '      return $this->%1$s;'.PHP_EOL.
        '    }'.PHP_EOL.PHP_EOL,
        $name, ucfirst($name), $type, ('boolean' == $type ? 'is' : 'get')
      );
    }

  }
?>
