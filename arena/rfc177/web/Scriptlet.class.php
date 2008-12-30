<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('web.ScriptletRequest', 'web.ScriptletResponse', 'web.ScriptletException');

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
     * @param   web.ScriptletRequest request
     * @param   web.ScriptletResponse response
     * @throws  web.ScriptletException to indicate fatal error situations
     */
    abstract public function service(ScriptletRequest $request, ScriptletResponse $response);
    
  }
?>
