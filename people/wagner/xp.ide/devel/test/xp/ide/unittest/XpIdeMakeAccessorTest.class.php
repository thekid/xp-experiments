<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.ide.unittest.TestCase',
    'xp.ide.XpIde',
    'xp.ide.AccessorConfig',
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
  class XpIdeMakeAccessorTest extends xp·ide·unittest·TestCase {
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
        $this->in= new TextReader(new MemoryInputStream('')),
        $this->out= new TextWriter(new MemoryOutputStream()),
        $this->err= new TextWriter(new MemoryOutputStream())
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorsEmpty() {
      $this->ide->createAccessors(array());
      $this->assertEquals('', $this->out->getStream()->getBytes());
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createAccessorsNoSet() {
      $conf[0]= new xp·ide·AccessorConfig('in', 'string');
      $this->ide->createAccessors($conf);
      $this->assertEquals('', $this->out->getStream()->getBytes());
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSettterOne() {
      $conf[0]= new xp·ide·AccessorConfig('in', 'string');
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('in', 'string'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterTwo() {
      $conf[0]= new xp·ide·AccessorConfig('in', 'string');
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[1]= new xp·ide·AccessorConfig('out', 'string');
      $conf[1]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('in', 'string').
        $this->createSetter('out', 'string'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createGetterOne() {
      $conf[0]= new xp·ide·AccessorConfig('in', 'string');
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createGetter('in', 'string'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createGetterTwo() {
      $conf[0]= new xp·ide·AccessorConfig('in', 'string');
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $conf[1]= new xp·ide·AccessorConfig('out', 'string');
      $conf[1]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createGetter('in', 'string').
        $this->createGetter('out', 'string'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterOne() {
      $conf[0]= new xp·ide·AccessorConfig('in', 'string');
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('in', 'string').
        $this->createGetter('in', 'string'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterTwo() {
      $conf[0]= new xp·ide·AccessorConfig('in', 'string');
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $conf[1]= new xp·ide·AccessorConfig('out', 'string');
      $conf[1]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $conf[1]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('in', 'string').
        $this->createGetter('in', 'string').
        $this->createSetter('out', 'string').
        $this->createGetter('out', 'string'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterInt() {
      $conf[0]= new xp·ide·AccessorConfig('count', 'integer');
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('count', 'integer').
        $this->createGetter('count', 'integer'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterBool() {
      $conf[0]= new xp·ide·AccessorConfig('final', 'boolean');
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('final', 'boolean').
        $this->createGetter('final', 'boolean'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterObject() {
      $conf[0]= new xp·ide·AccessorConfig('root', 'object', 'lang.Object');
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('root', 'lang.Object', 'Object').
        $this->createGetter('root', 'lang.Object'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterNamespaceObject() {
      $conf[0]= new xp·ide·AccessorConfig('ide', 'object', 'xp.ide.XpIde');
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('ide', 'xp.ide.XpIde', 'xp·ide·XpIde').
        $this->createGetter('ide', 'xp.ide.XpIde'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterArray() {
      $conf[0]= new xp·ide·AccessorConfig('names', 'array', 'string', 1);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('names', 'string[]', 'array').
        $this->createGetter('names', 'string[]'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterArrayDim2() {
      $conf[0]= new xp·ide·AccessorConfig('names', 'array', 'string', 2);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('names', 'string[][]', 'array').
        $this->createGetter('names', 'string[][]'),
        $this->out->getStream()->getBytes()
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function createSetterGetterArrayObject() {
      $conf[0]= new xp·ide·AccessorConfig('names', 'array', 'lang.Object', 1);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
      $conf[0]->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      $this->ide->createAccessors($conf);
      $this->assertEquals(
        $this->createSetter('names', 'lang.Object[]', 'array').
        $this->createGetter('names', 'lang.Object[]'),
        $this->out->getStream()->getBytes()
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
