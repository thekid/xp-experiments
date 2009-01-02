<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @purpose  purpose
   */
  interface ScriptletConfig {
    
    /**
     * Returns a request dispatcher
     *
     * @param   string path
     * @return  web.scriptlet.RequestDispatcher
     */
    public function dispatcher($path);
  }
?>
