<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.net.Resolver', 
    'peer.net.Message', 
    'peer.net.ARecord',
    'peer.net.CNAMERecord',
    'peer.net.MXRecord',
    'peer.net.AAAARecord'
  );

  /**
   * Resolver that uses PHP's native method
   *
   * @see   php://dns_get_record
   */
  class NativeResolver extends Object implements peer·net·Resolver {
    
    /**
     * Send query for resolution and return nameservers records
     *
     * @param   peer.net.Message query
     * @return  peer.net.Record[] records
     */
    public function send(peer·net·Message $query) {
      $results= dns_get_record(this($query->getRecords(), 0), $query->getType());

      $records= array();
      foreach ($results as $result) {
        switch ($result['type']) {
          case 'A': 
            $records[]= new ARecord($result['host'], $result['ip']);
            break;
          
          // TODO: Implement rest
          
          default:
            throw new ProtocolException('Unknown record type '.$result['type']);
        }
      }
      
      return $records;
    }
  }
?>
  
