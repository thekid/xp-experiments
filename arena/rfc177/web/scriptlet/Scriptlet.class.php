<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('web.scriptlet.ScriptletRequest', 'web.scriptlet.ScriptletResponse', 'web.scriptlet.ScriptletException');

  /**
   * Base scriptlet
   *
   * @purpose  Abstract base class
   */
  abstract class Scriptlet extends Object {
    protected $config= NULL;
  
    /**
     * Set scriptlet configuration
     *
     * @param   * config
     */
    public function init($config) {
      $this->config= $config;
    }

    /**
     * Service a request
     *
     * @param   web.scriptlet.ScriptletRequest request
     * @param   web.scriptlet.ScriptletResponse response
     * @throws  web.scriptlet.ScriptletException to indicate fatal error situations
     */
    abstract public function service(ScriptletRequest $request, ScriptletResponse $response);
    
  }
?>
