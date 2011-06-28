<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'net.xp_framework.unittest.peer.net';

  uses(
    'unittest.TestCase',
    'peer.net.dns.Response',
    'peer.net.dns.RCode'
  );

  /**
   * TestCase
   *
   * @see      xp://peer.net.dns.Response
   */
  class net·xp_framework·unittest·peer·net·ResponseTest extends TestCase {
    protected $record;

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->record= newinstance('peer.net.dns.Record', array('test', 0), '{}');
    }

    /**
     * Test constructor accepts result code
     *
     */
    #[@test]
    public function resultCode() {
      $this->assertEquals(RCode::$SUCCESS, create(new peer·net·dns·Response(0, array()))->result());
    }

    /**
     * Test constructor accepts result code
     *
     */
    #[@test]
    public function resultRCodeInstance() {
      $this->assertEquals(RCode::$NXDOMAIN, create(new peer·net·dns·Response(RCode::$NXDOMAIN, array()))->result());
    }
    
    /**
     * Create a new response
     *
     * @param   int section
     * @param   peer.net.dns.Record[] records
     * @return  peer.net.dns.Response
     */
    protected function newResponseWith($section, $records) {
      return new peer·net·dns·Response(RCode::$SUCCESS, array($section => $records));
    }

    /**
     * Test records() method
     *
     */
    #[@test]
    public function recordsWithAnswerFilled() {
      $this->assertEquals(
        array(
          Sections::QUESTION    => array(),
          Sections::ANSWER      => array($this->record),
          Sections::AUTHORITY   => array(),
          Sections::ADDITIONAL  => array(),
        ),
        $this->newResponseWith(Sections::ANSWER, array($this->record))->records()
      );
    }

    /**
     * Test records() method
     *
     */
    #[@test]
    public function recordsWithAuthorityFilled() {
      $this->assertEquals(
        array(
          Sections::QUESTION    => array(),
          Sections::ANSWER      => array(),
          Sections::AUTHORITY   => array($this->record),
          Sections::ADDITIONAL  => array(),
        ),
        $this->newResponseWith(Sections::AUTHORITY, array($this->record))->records()
      );
    }
    
    /**
     * Test answers() method
     *
     */
    #[@test]
    public function answers() {
      $this->assertEquals(
        array($this->record), 
        $this->newResponseWith(Sections::ANSWER, array($this->record))->answers()
      );
    }

    /**
     * Test answers() method
     *
     */
    #[@test]
    public function noAnswers() {
      $this->assertEquals(
        array(),
        $this->newResponseWith(Sections::QUESTION, array())->answers()
      );
    }

    /**
     * Test authorities() method
     *
     */
    #[@test]
    public function authorities() {
      $this->assertEquals(
        array($this->record), 
        $this->newResponseWith(Sections::AUTHORITY, array($this->record))->authorities()
      );
    }

    /**
     * Test additional() method
     *
     */
    #[@test]
    public function additional() {
      $this->assertEquals(
        array($this->record), 
        $this->newResponseWith(Sections::ADDITIONAL, array($this->record))->additional()
      );
    }
  }
?>
