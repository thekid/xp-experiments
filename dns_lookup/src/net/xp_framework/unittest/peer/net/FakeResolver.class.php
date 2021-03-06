<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.dns.Resolver');

  /**
   * Fake resolver 
   *
   * @see      xp://net.xp_framework.unittest.peer.net.CompositeResolverTest
   */
  class FakeResolver extends Object implements peer�net�dns�Resolver {
    protected $records= array();
    protected $exception= NULL;
  
    /**
     * Make this fake resolver return a record
     *
     * @param   peer.net.dns.Record[] records
     * @return  net.xp_framework.unittest.peer.net.FakeResolver this
     */
    public function returning(array $records) {
      $this->records= $records;
      return $this;
    }
    
    /**
     * Make this fake resolver throw an exception
     *
     * @param   lang.Throwable exception
     * @return  net.xp_framework.unittest.peer.net.FakeResolver this
     */
    public function throwing(Throwable $exception) {
      $this->exception= $exception;
      return $this;
    }

    /**
     * Set domain
     *
     * @param   string name
     */
    public function setDomain($name) {
      // Intentionally empty
    }

    /**
     * Set search list
     *
     * @param   string[] domains
     */
    public function setSearch($domains) {
      // Intentionally empty
    }
    
    /**
     * Send query for resolution and return nameservers records
     *
     * @param   peer.net.dns.Message query
     * @return  peer.net.dns.Message response
     */
    public function send(peer�net�dns�Message $query) {
      if (NULL !== $this->exception) {
        throw $this->exception;
      }

      $message= new peer�net�dns�Message();
      foreach ($this->records as $record) {
        $message->addRecord(Sections::ANSWER, $record);
      }
      return $message;
    }
  }
?>
