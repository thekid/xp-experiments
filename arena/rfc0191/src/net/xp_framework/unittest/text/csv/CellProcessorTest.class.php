<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'text.csv.CsvListReader',
    'text.csv.processors.AsInteger',
    'text.csv.processors.AsDouble',
    'text.csv.processors.AsDate',
    'text.csv.processors.AsBool',
    'text.csv.processors.AsEnum',
    'text.csv.processors.constraint.Optional',
    'text.csv.processors.constraint.Required',
    'net.xp_framework.unittest.core.Coin',
    'io.streams.MemoryInputStream'
  );

  /**
   * TestCase
   *
   * @see      xp://text.csv.CellProcessor
   */
  class CellProcessorTest extends TestCase {

    /**
     * Creates a new list reader
     *
     * @param   string str
     * @param   text.csv.CsvFormat format
     * @return  text.csv.CsvListReader
     */
    protected function newReader($str, CsvFormat $format= NULL) {
      return new CsvListReader(new TextReader(new MemoryInputStream($str)), $format);
    }
  
    /**
     * Test AsInteger processor
     *
     */
    #[@test]
    public function asInteger() {
      $in= $this->newReader('1549;Timm')->withProcessors(array(
        new AsInteger(),
        NULL
      ));
      $this->assertEquals(array(1549, 'Timm'), $in->read());
    }

    /**
     * Test AsInteger processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function stringAsInteger() {
      $this->newReader('A;Timm')->withProcessors(array(
        new AsInteger(),
        NULL
      ))->read();
    }

    /**
     * Test AsInteger processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function emptyAsInteger() {
      $this->newReader(';Timm')->withProcessors(array(
        new AsInteger(),
        NULL
      ))->read();
    }

    /**
     * Test AsDouble processor
     *
     */
    #[@test]
    public function asDouble() {
      $in= $this->newReader('1.5;em')->withProcessors(array(
        new AsDouble(),
        NULL
      ));
      $this->assertEquals(array(1.5, 'em'), $in->read());
    }

    /**
     * Test AsDouble processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function stringAsDouble() {
      $this->newReader('A;em')->withProcessors(array(
        new AsDouble(),
        NULL
      ))->read();
    }

    /**
     * Test AsDouble processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function emptyAsDouble() {
      $this->newReader(';em')->withProcessors(array(
        new AsDouble(),
        NULL
      ))->read();
    }

    /**
     * Test AsDate processor
     *
     */
    #[@test]
    public function asDate() {
      $in= $this->newReader('2009-09-09 15:45;Order placed')->withProcessors(array(
        new AsDate(),
        NULL
      ));
      $this->assertEquals(array(new Date('2009-09-09 15:45'), 'Order placed'), $in->read());
    }

    /**
     * Test AsDate processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function invalidAsDate() {
      $this->newReader('YYYY-MM-DD HH:MM;Order placed')->withProcessors(array(
        new AsDate(),
        NULL
      ))->read();
    }

    /**
     * Test AsDate processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function emptyAsDate() {
      $this->newReader(';Order placed')->withProcessors(array(
        create(new AsDate()),
        NULL
      ))->read();
    }

    /**
     * Test AsDate processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function emptyAsDateWithNullDefault() {
      $this->newReader(';Order placed')->withProcessors(array(
        create(new AsDate())->withDefault(NULL),
        NULL
      ))->read();
    }

    /**
     * Test AsDate processor returns the default date
     *
     */
    #[@test]
    public function emptyAsDateWithDefault() {
      $now= Date::now();
      $in= $this->newReader(';Order placed')->withProcessors(array(
        create(new AsDate())->withDefault($now),
        NULL
      ));
      $this->assertEquals(array($now, 'Order placed'), $in->read());
    }

    /**
     * Test AsBool processor
     *
     */
    #[@test]
    public function trueAsBool() {
      $in= $this->newReader('Timm;true')->withProcessors(array(
        NULL,
        new AsBool()
      ));
      $this->assertEquals(array('Timm', TRUE), $in->read());
    }

    /**
     * Test AsBool processor
     *
     */
    #[@test]
    public function oneAsBool() {
      $in= $this->newReader('Timm;1')->withProcessors(array(
        NULL,
        new AsBool()
      ));
      $this->assertEquals(array('Timm', TRUE), $in->read());
    }

    /**
     * Test AsBool processor
     *
     */
    #[@test]
    public function yAsBool() {
      $in= $this->newReader('Timm;Y')->withProcessors(array(
        NULL,
        new AsBool()
      ));
      $this->assertEquals(array('Timm', TRUE), $in->read());
    }

    /**
     * Test AsBool processor
     *
     */
    #[@test]
    public function falseAsBool() {
      $in= $this->newReader('Timm;false')->withProcessors(array(
        NULL,
        new AsBool()
      ));
      $this->assertEquals(array('Timm', FALSE), $in->read());
    }

    /**
     * Test AsBool processor
     *
     */
    #[@test]
    public function zeroAsBool() {
      $in= $this->newReader('Timm;0')->withProcessors(array(
        NULL,
        new AsBool()
      ));
      $this->assertEquals(array('Timm', FALSE), $in->read());
    }

    /**
     * Test AsBool processor
     *
     */
    #[@test]
    public function nAsBool() {
      $in= $this->newReader('Timm;N')->withProcessors(array(
        NULL,
        new AsBool()
      ));
      $this->assertEquals(array('Timm', FALSE), $in->read());
    }

    /**
     * Test AsBool processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function emptyAsBool() {
      $this->newReader('Timm;;')->withProcessors(array(
        NULL,
        new AsBool()
      ))->read();
    }

    /**
     * Test AsEnum processor
     *
     */
    #[@test]
    public function pennyCoin() {
      $in= $this->newReader('200;penny')->withProcessors(array(
        NULL,
        new AsEnum(XPClass::forName('net.xp_framework.unittest.core.Coin'))
      ));
      $this->assertEquals(array('200', Coin::$penny), $in->read());
    }

    /**
     * Test AsEnum processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function invalidCoin() {
      $this->newReader('200;dollar')->withProcessors(array(
        NULL,
        new AsEnum(XPClass::forName('net.xp_framework.unittest.core.Coin'))
      ))->read();
    }

    /**
     * Test AsEnum processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function emptyCoin() {
      $this->newReader('200;;')->withProcessors(array(
        NULL,
        new AsEnum(XPClass::forName('net.xp_framework.unittest.core.Coin'))
      ))->read();
    }

    /**
     * Test Optional processor
     *
     */
    #[@test]
    public function optionalString() {
      $in= $this->newReader('200;OK;')->withProcessors(array(
        NULL,
        new Optional()
      ));
      $this->assertEquals(array('200', 'OK'), $in->read());
    }
    
    /**
     * Test Optional processor
     *
     */
    #[@test]
    public function optionalEmpty() {
      $in= $this->newReader('666;;')->withProcessors(array(
        NULL,
        new Optional()
      ));
      $this->assertEquals(array('666', NULL), $in->read());
    }

    /**
     * Test Optional processor
     *
     */
    #[@test]
    public function optionalEmptyWithDefault() {
      $in= $this->newReader('666;;')->withProcessors(array(
        NULL,
        create(new Optional())->withDefault('(unknown)')
      ));
      $this->assertEquals(array('666', '(unknown)'), $in->read());
    }

    /**
     * Test Required processor
     *
     */
    #[@test]
    public function requiredString() {
      $in= $this->newReader('200;OK;')->withProcessors(array(
        NULL,
        new Required()
      ));
      $this->assertEquals(array('200', 'OK'), $in->read());
    }
    
    /**
     * Test Required processor
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function requiredEmpty() {
      $this->newReader('666;;')->withProcessors(array(
        NULL,
        new Required()
      ))->read();
    }
  }
?>
