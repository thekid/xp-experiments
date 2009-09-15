<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'text.csv.CsvListReader',
    'text.csv.processors.lookup.DataSetLookup',
    'net.xp_framework.unittest.rdbms.dataset.Person',
    'net.xp_framework.unittest.rdbms.mock.MockConnection',
    'io.streams.MemoryInputStream'
  );

  /**
   * TestCase
   *
   * @see      xp://text.csv.CellProcessor
   */
  class DataSetCellProcessorTest extends TestCase {

    /**
     * Mock connection registration
     *
     */  
    #[@beforeClass]
    public static function registerMockConnection() {
      DriverManager::register('mock', XPClass::forName('net.xp_framework.unittest.rdbms.mock.MockConnection'));
      Person::getPeer()->setConnection(DriverManager::getConnection('mock://mock/JOBS?autoconnect=1'));
    }

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
     * Test successful lookup
     *
     */
    #[@test]
    public function lookup() {
      Person::getPeer()->getConnection()->setResultSet(new MockResultSet(array(
        array('person_id' => 1549, 'name' => 'Timm')
      )));
      $in= $this->newReader("person_id;commits\n1549;10248")->withProcessors(array(
        new DataSetLookup(Person::getPeer()),
        NULL
      ));
      $in->getHeaders();
      $list= $in->read();
      $this->assertClass($list[0], 'net.xp_framework.unittest.rdbms.dataset.Person');
      $this->assertEquals(1549, $list[0]->getPerson_id());
    }

    /**
     * Test successful lookup
     *
     */
    #[@test]
    public function lookupByCriteria() {
      Person::getPeer()->getConnection()->setResultSet(new MockResultSet(array(
        array('person_id' => 1549, 'name' => 'Timm')
      )));
      $in= $this->newReader("name;commits\nTimm;10248")->withProcessors(array(
        new DataSetLookup(Person::getPeer(), create(new Criteria())
          ->add('name', new QueryParameter(), EQUAL)
          ->add('department_id', 6100, EQUAL)
        ),
        NULL
      ));
      $in->getHeaders();
      $list= $in->read();
      $this->assertClass($list[0], 'net.xp_framework.unittest.rdbms.dataset.Person');
      $this->assertEquals(1549, $list[0]->getPerson_id());
    }

    /**
     * Test lookup not returning a result
     *
     */
    #[@test]
    public function notFound() {
      Person::getPeer()->getConnection()->setResultSet(new MockResultSet(array()));
      $in= $this->newReader("person_id;commits\n1549;10248")->withProcessors(array(
        new DataSetLookup(Person::getPeer()),
        NULL
      ));
      $in->getHeaders();
      try {
        $in->read();
        $this->fail('Lookup succeeded', NULL, 'lang.FormatException');
      } catch (FormatException $expected) { }
    }

    /**
     * Test lookup returning more than one result
     *
     */
    #[@test]
    public function ambiguous() {
      Person::getPeer()->getConnection()->setResultSet(new MockResultSet(array(
        array('person_id' => 1549, 'name' => 'Timm'),
        array('person_id' => 1549, 'name' => 'Doppelgänger'),
      )));
      $in= $this->newReader("person_id;commits\n1549;10248")->withProcessors(array(
        new DataSetLookup(Person::getPeer()),
        NULL
      ));
      $in->getHeaders();
      try {
        $in->read();
        $this->fail('Lookup succeeded', NULL, 'lang.FormatException');
      } catch (FormatException $expected) { }
    }
  }
?>
