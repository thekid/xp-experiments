<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net';

  uses('peer.net.Message');

  /**
   * Resolver
   *
   */
  interface peer�net�Resolver {
    
    /**
     * Send query for resolution and return nameservers records
     *
     * @param   peer.net.Message query
     * @return  peer.net.Record[] records
     */
    public function send(peer�net�Message $query);
  }
?>
