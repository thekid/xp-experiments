<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.DefaultResolver', 'peer.net.CompositeResolver');

  /**
   * (Insert class' description here)
   *
   */
  class Resolvers extends Object {
    
    /**
     * Retrieve the system resolver
     *
     * @return  peer.net.Resolver
     */
    public static function systemResolver() {
    
      // Fetch DNS server(s)
      $resolver= new CompositeResolver();
      if (strncasecmp(PHP_OS, 'Win', 3) === 0) {
        try {
          $c= new COM('winmgmts://./root/cimv2');
          $q= $c->ExecQuery('select DNSServerSearchOrder from Win32_NetworkAdapterConfiguration where IPEnabled = true');
          foreach ($q as $result) {
            foreach ($result->DNSServerSearchOrder as $server) {
              $resolver->addDelegate(new DefaultResolver($server));
            }
          }
        } catch (Exception $e) {
          throw new IllegalStateException($e->getMessage());
        }
      } else if (file_exists('/etc/resolv.conf')) {
        foreach (file('/etc/resolv.conf') as $line) {
          if (strncmp($line, 'nameserver', 10) === 0) {
            $resolver->addDelegate(new DefaultResolver(rtrim(substr($line, 11))));
          }
        }
      } else {
        throw new IllegalStateException('No system resolvers could be determined');
      }
      
      return $resolver;
    }
  }
?>
