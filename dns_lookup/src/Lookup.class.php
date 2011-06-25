<?php
  uses(
    'peer.net.Resolvers', 
    'peer.net.QType', 
    'peer.net.Question',
    'peer.net.Response',
    'util.profiling.Timer'
  );

  class Lookup extends Object {
  
    protected static function typeNamed($name) {
      return Enum::valueOf(XPClass::forName('peer.net.QType'), $name);
    }

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
      }

      $name= $args[$shift];
      $types= array_slice($args, $shift+ 1);
      Console::writeLine('>>> ', $name, '->(', implode(' & ', $types), ') @ ', $resolver);

      $requests= array();
      foreach ($types as $type) {
        $response= $resolver->send(new Question($name, self::typeNamed($type)));
        $result= new peer·net·Response($response->getRcode(), $response->getRecords());

        Console::writeLine('<<< ', $result);
      }
    }
  }
?>
