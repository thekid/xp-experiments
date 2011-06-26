<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'net.xp_framework.unittest.peer.net';

  uses(
    'unittest.TestCase',
    'peer.net.Response',
    'peer.net.RCode'
  );

  /**
   * TestCase
   *
   * @see      xp://peer.net.Response
   */
  class net暖p_framework暉nittest搆eer搖et愛esponseTest extends TestCase {
    protected $record;

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->record= newinstance('peer.net.Record', array('test', 0), '{}');
    }

    /**
     * Test constructor accepts result code
     *
     */
    #[@test]
    public function resultCode() {
      $this->assertEquals(RCode::$SUCCESS, create(new peer搖et愛esponse(0, array()))->result());
    }

    /**
     * Test constructor accepts result code
     *
     */
    #[@test]
    public function resultRCodeInstance() {
      $this->assertEquals(RCode::$NXDOMAIN, create(new peer搖et愛esponse(RCode::$NXDOMAIN, array()))->result());
    }
    
    /**
     * Create a new response
     *
     * @param   int section
     * @param   peer.net.Record[] records
     * @return  peer.net.Response
     */
    protected function newResponseWith($section, $records) {
      return new peer搖et愛esponse(RCode::$SUCCESS, array($section => $records));
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
