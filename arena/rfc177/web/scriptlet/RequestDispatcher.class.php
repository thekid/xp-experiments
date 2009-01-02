<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @purpose  Interface
   */
  interface RequestDispatcher {
    
    /**
     * Dispatch a request
     *
     * @param   web.ScriptletRequest request
     * @param   web.ScriptletResponse response
     */
    public function dispatch(ScriptletRequest $request, ScriptletResponse $response);
  }
?>
