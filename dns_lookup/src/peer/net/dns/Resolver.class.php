<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net.dns';

  uses(
    'peer.net.dns.ResolveException',
    'peer.net.dns.Message',
    'peer.net.dns.ARecord',
    'peer.net.dns.CNAMERecord',
    'peer.net.dns.MXRecord',
    'peer.net.dns.NSRecord',
    'peer.net.dns.AAAARecord',
    'peer.net.dns.TXTRecord',
    'peer.net.dns.SRVRecord',
    'peer.net.dns.PTRRecord',
    'peer.net.dns.NAPTRRecord',
    'peer.net.dns.SOARecord'
  );

  /**
   * Resolver
   *
   */
  interface peer·net·dns·Resolver {
    
    /**
     * Send query for resolution and return nameservers records
     *
     * @param   peer.net.Message query
     * @return  peer.net.Message The response
     * @throws  peer.net.ResolveException
     * @throws  lang.Throwable
     */
    public function send(peer·net·dns·Message $query);

    /**
     * Set domain
     *
     * @param   string name
     */
    public function setDomain($name);

    /**
     * Set search list
     *
     * @param   string[] domains
     */
    public function setSearch($domains);
  }
?>
