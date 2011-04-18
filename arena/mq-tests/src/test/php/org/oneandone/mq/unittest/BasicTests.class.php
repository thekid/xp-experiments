<?php
/* This class is part of the XP framework
 *
 * $Id$
 */


  uses(
    'org.codehaus.stomp.StompConnection',
    'util.log.Logger',
    'util.Date');

  /**
 * Test cases for
 */
  class BasicTests extends TestCase {
    private 
    $sender= null,
    $receiver= null,
    $queue='/queue/test/delay';

    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
      $this->sender= new StompConnection('vm720.development.lan', 61613);
      $this->sender->setTrace(Logger::getInstance()->getCategory());
      $this->sender->connect('system', 'manager');
      
      $this->receiver= new StompConnection('vm721.development.lan', 61613);
      $this->receiver->setTrace(Logger::getInstance()->getCategory());
      $this->receiver->connect('system', 'manager');
      $this->receiver->subscribe($this->queue);

    }


    #[@test]
    public function delay_headers_should_delay_message() {
      $delay= 3000;
      $headers= array();
      $headers['AMQ_SCHEDULED_DELAY']= $delay;
      $headers['persistent']= 'true';
      $msg= 'foooup!? - '.uniqid();
      $this->sender->send($this->queue, $msg, $headers);
      $sendtime= Date::now();

      $message= $this->receiver->receive($delay/1000.0 + 5); //wait for it
      $rcvtime= Date::now();

      $this->assertTrue(($rcvtime->getTime() - $sendtime->getTime() + 1) >= $delay/1000.0); //at least $deleay-1 secs
      $this->assertEquals($msg, $message->getBody());
    }

    #[@test]
    public function make_many_messages() {
      $count= 500;
      $delay=50000;

      $headers= array();
     // $headers['AMQ_SCHEDULED_DELAY']= $delay;
      $headers['persistent']='true';
      $msg= 'whaaaazuuup!? - '.uniqid();
      for($i=0; $i<$count; ++$i) {
        $this->sender->send($this->queue, $msg, $headers);
      }
    }


  }
