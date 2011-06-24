<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Resolver');

  /**
   * Resolver that queries a list of resolvers
   *
   * @test    xp://net.xp_framework.unittest.peer.net.CompositeResolverTest
   */
  class CompositeResolver extends Object implements peer·net·Resolver {
    protected $resolvers= array();
    
    /**
     * Create a composite resolver
     *
     * @param   peer.net.Resolver[] resolvers
     */
    public function __construct($resolvers= array()) {
      $this->delegates= $resolvers;
    }

    /**
     * Add a resolver delegate to this composite
     *
     * @param   peer.net.Resolver resolver
     * @return  peer.net.Resolver the added resolver
     */
    public function addDelegate(peer·net·Resolver $resolver) {
      $this->delegates[]= $resolver;
      return $resolver;
    }

    /**
     * Add a resolver delegate to this composite
     *
     * @param   peer.net.Resolver resolver
     * @return  peer.net.CompositeResolver this composite resolver
     */
    public function withDelegate(peer·net·Resolver $resolver) {
      $this->delegates[]= $resolver;
      return $this;
    }

    /**
     * Get whether resolver delegates exists
     *
     * @return  bool
     */
    public function hasDelegates() {
      return !empty($this->delegates);
    }

    /**
     * Get all resolver delegates
     *
     * @return  peer.net.Resolver[]
     */
    public function getDelegates() {
      return $this->delegates;
    }
    
    /**
     * Send query for resolution and return nameservers records
     *
     * @param   peer.net.Message query
     * @return  peer.net.Record[] records
     */
    public function send(peer·net·Message $query) {
      if (empty($this->delegates)) {
        throw new IllegalStateException('No resolvers to query');
      }

      $t= NULL;
      foreach ($this->delegates as $resolver) {
        try {
          return $resolver->send($query);
        } catch (Throwable $t) {
          continue;
        }
      }
      throw $t;
    }
  }
?>
