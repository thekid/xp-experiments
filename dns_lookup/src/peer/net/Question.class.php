<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.net.Message',
    'peer.net.QType', 
    'peer.net.Query'
  );

  /**
   * Question
   *
   * <code>
   *   $response= $resolver->send(new Question($name, QType::$AAAA));
   * </code>
   */
  class Question extends peer·net·Message {
    
    /**
     * Create a new question object
     *
     * @param   string name
     * @param   peer.net.QType type default NULL if omitted, ANY
     * @param   int qclass default 1
     */
    public function __construct($name, QType $type= NULL, $qclass= 1) {
      parent::__construct();
      $this->setOpcode(0);                // Question
      $this->setFlags(0x0100 & 0x0300);   // Recursion & Queryspecmask
      $this->addRecord(new peer·net·Query(
        $name, 
        NULL === $type ? QType::$ANY : $type,
        $qclass
      ));
    }
  }
?>
