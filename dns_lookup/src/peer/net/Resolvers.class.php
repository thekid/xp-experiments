<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.DefaultResolver');

  /**
   * (Insert class' description here)
   *
   */
  class Resolvers extends Object {
    
    /**
     * (Insert method's description here)
     *
     * @return  peer.net.Resolver
     */
    public static function systemResolver() {
    
      // Fetch DNS server(s)
      $nameservers= array();
      if (1) {
        $c= new COM('winmgmts://./root/cimv2');
        $q= $c->ExecQuery('select DNSServerSearchOrder from Win32_NetworkAdapterConfiguration where IPEnabled = true');
        foreach ($q as $result) {
          foreach ($result->DNSServerSearchOrder as $server) {
            $nameservers[]= $server;
          }
        }
      }
      
      return new DefaultResolver($nameservers[0]);
    }
  }
?>
