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
     * dns_get_record() function, and it is not broken on this combination.
     * Otherwise, the default resolver is what systemResolver() returns.
     * 
     * Note: Results from this methods are cached.
     *
     * @return  peer.net.Resolver
     */
    public static function defaultResolver() {
      if (NULL === self::$default) {
      
        // Check for broken dns_get_record() for NAPTR records. Compare:
        //
        // http://lxr.php.net/opengrok/xref/PHP_5_3/ext/standard/dns_win32.c#308 vs.
        // http://lxr.php.net/opengrok/xref/PHP_5_4/ext/standard/dns_win32.c#315
        //
        // The DNS_TYPE_NAPTR case is jumped into, but the #if is not executed in 
        // the VC6 builds, so basically the case statement is a NOOP, leaving 
        // the array without a "type" element. Fixed in branches/PHP_5_4 and trunk
        // but not backported to PHP_5_3 branch. As of 5.3.6, the PHP group has
        // decided no longer to support VC6, so this workaround only applies for
        // PHP 5.3.0 - PHP 5.3.5. Really, PHP 5.3.5+VC9 would also work here, but
        // there's no performant way to detect the compiler used, so we'll live
        // with the workaround.
        if (!function_exists('dns_get_record') || (
          0 === strncasecmp(PHP_OS, 'Win', 3) && 
          version_compare(PHP_VERSION, '5.3.6', 'lt')
        )) {
          self::$default= self::systemResolver();
        } else {
          self::$default= new NativeResolver();
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
          $q= $c->ExecQuery('select DNSServerSearchOrder, DNSDomain, DNSDomainSuffixSearchOrder from Win32_NetworkAdapterConfiguration where IPEnabled = true');
          foreach ($q as $result) {
            foreach ($result->DNSServerSearchOrder as $server) {
              $resolver->addDelegate(new DnsResolver($server));
            }
            $resolver->setDomain($result->DNSDomain);
            $resolver->setSearch($result->DNSDomainSuffixSearchOrder);
          }
        } catch (Exception $e) {
          throw new IllegalStateException($e->getMessage());
        }
      } else if (file_exists('/etc/resolv.conf')) {
        foreach (file('/etc/resolv.conf') as $line) {
          if (strncmp($line, 'nameserver', 10) === 0) {
            $resolver->addDelegate(new DnsResolver(rtrim(substr($line, 11))));
          } else if (strncmp($line, 'domain', 6) === 0) {
            $resolver->setDomain(rtrim(substr($line, 7)));
          } else if (strncmp($line, 'search', 6) === 0) {
            $resolver->setSearch(explode(' ', rtrim(substr($line, 7))));
          }
        }
      } else {
        throw new IllegalStateException('No system resolvers could be determined');
      }
      
      return $resolver;
    }
  }
?>
