<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.net.Message',
    'peer.net.QType', 
    'peer.net.QClass', 
    'peer.net.Query'
  );

  /**
   * Question message
   *
   * <code>
   *   $response= $resolver->send(new Question($name, QType::$AAAA));
   * </code>
   * 
   * @test    xp://net.xp_framework.unittest.peer.net.QuestionTest
   */
  class Question extends peer·net·Message {
    
    /**
     * Create a new question object
     *
     * @param   string name
     * @param   peer.net.QType qtype default NULL if omitted, ANY
     * @param   peer.net.QClass qclass default NULL if omitted, IN
     */
    public function __construct($name, QType $qtype= NULL, QClass $qclass= NULL) {
      parent::__construct();                // Generate an ID
      $this->setOpcode(0);                  // Question
      $this->setFlags(0x0100 & 0x0300);     // Recursion & Queryspecmask

      $this->addRecord(Sections::QUESTION, new peer·net·Query(
        $name, 
        NULL === $qtype ? QType::$ANY : $qtype,
        NULL === $qclass ? QClass::$IN : $qclass
      ));
    }
    
    /**
     * Creates a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      $r= cast($this->records[Sections::QUESTION][0], 'peer.net.Query');
      return pack('nna*', $r->getQType()->ordinal(), $r->getQClass()->ordinal(), $r->getName());
    }
    
    /**
     * Checks whether another value is equal to this
     *
     * @param   var cmp
     * @return  bool
     */
    public function equals($cmp) {
      return (
        $cmp instanceof self &&
        $cmp->hashCode() === $this->hashCode()
      );
    }

    /**
     * Creates a string representation of this question
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.xp::stringOf($this->records[0]).')';
    }
  }
?>
