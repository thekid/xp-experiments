<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.net.dns.Resolvers', 
    'peer.net.dns.QType', 
    'peer.net.dns.Question',
    'peer.net.dns.Response',
    'util.profiling.Timer'
  );

  /**
   * Demonstrate DNS API usage
   *
   */
  class Lookup extends Object {
  
    /**
     * Entry point
     *
     * @param   string[] args
     */
    public static function main(array $args) {
      if ('-s' === $args[0]) {
        $resolver= Resolvers::systemResolver();
        $shift= 1;
      } else if ('-d' === $args[0]) {
        $resolver= Resolvers::defaultResolver();
        $shift= 1;
      } else if ('-r' === $args[0]) {
        $resolver= new DnsResolver($args[1]);
        $shift= 2;
      } else {
        $resolver= Resolvers::defaultResolver();
        $shift= 0;
      }
      
      $name= $args[$shift];
      $types= array_slice($args, $shift+ 1);
      Console::writeLine('>>> ', $name, '->(', implode(' & ', $types), ') @ ', $resolver);

      $requests= array();
      foreach ($types as $type) {
        $response= $resolver->send(new Question($name, QType::named($type)));
        $result= new peer·net·dns·Response($response->getRcode(), $response->allRecords());

        Console::writeLine('<<< ', $result);
      }
    }
  }
?>
