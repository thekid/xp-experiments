<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.CompositeResolver', 'peer.net.DnsResolver', 'peer.net.NativeResolver');

  /**
   * System / resolvers interface
   *
   * @see   http://linux.die.net/man/5/resolv.conf
   * @see   http://msdn.microsoft.com/en-us/library/aa394217(v=vs.85).aspx
   * @see   php://dns_get_record
   */
  class Resolvers extends Object {
    protected static $default= NULL;
      
    /**
     * Returns the default resolver. This is the native resolver when we 
     * are running on a PHP version / OS combination that supports the
     * dns_get_record() function, the results of the systemResolver() 
     * method otherwise.
     * 
     * Note: Results from this methods are cached.
     *
     * @return  peer.net.Resolver
     */
    public static function defaultResolver() {
      if (NULL === self::$default) {
        if (function_exists('dns_get_record')) {
          self::$default= new NativeResolver();
        } else {
          self::$default= self::systemResolver();
        }
      }
      return self::$default;
    }
    
    /**
     * Retrieve the system resolver
     *
     * @return  peer.net.Resolver
     */
    public static function systemResolver() {

      // Create a composite resolver from the DNS server(s) list we get from the OS.
      $resolver= new CompositeResolver();
      if (strncasecmp(PHP_OS, 'Win', 3) === 0) {
        try {
          $c= new COM('winmgmts://./root/cimv2');
          $q= $c->ExecQuery('select DNSServerSearchOrder from Win32_NetworkAdapterConfiguration where IPEnabled = true');
          foreach ($q as $result) {
            foreach ($result->DNSServerSearchOrder as $server) {
              $resolver->addDelegate(new DnsResolver($server));
            }
          }
        } catch (Exception $e) {
          throw new IllegalStateException($e->getMessage());
        }
      } else if (file_exists('/etc/resolv.conf')) {
        foreach (file('/etc/resolv.conf') as $line) {
          if (strncmp($line, 'nameserver', 10) === 0) {
            $resolver->addDelegate(new DnsResolver(rtrim(substr($line, 11))));
          }
        }
      } else {
        throw new IllegalStateException('No system resolvers could be determined');
      }
      
      return $resolver;
    }
  }
?>
