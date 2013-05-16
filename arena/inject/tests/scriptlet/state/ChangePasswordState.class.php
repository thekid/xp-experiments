<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('remote.Remote', 'scriptlet.xml.workflow.AbstractAuthenticatedState');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class ChangePasswordState extends AbstractAuthenticatedState {

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@inject('env/remote/service')]
    public function setDsn($dsn) {
      $this->remote= Remote::forName($dsn);
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@inject('env/ws/sap/orgeh')]
    public function setOrgehService($service) {
      
    }
  }
?>
