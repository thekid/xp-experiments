<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net';

  uses('peer.net.Message');

  /**
   * (Insert class' description here)
   *
   */
  interface peer·net·Resolver {
    
    /**
     * (Insert method's description here)
     *
     * @param   peer.net.Message query
     * @return  
     */
    public function send(peer·net·Message $query);
  }
?>
