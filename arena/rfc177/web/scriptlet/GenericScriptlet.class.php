<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('web.scriptlet.Scriptlet');

  /**
   * Provides a class for all scriptlets answering HTTP requests.
   *
   * Subclasses of this abstract class will implement at least one of
   * the following methods:
   * <ul>
   *   <li>doGet()</li>
   *   <li>doHead()</li>
   *   <li>doPost()</li>
   * </ul>
   *
   * The service() method dispatches requests to these methods depending
   * on the request method
   *
   * @see      xp://web.scriptlet.scriptlet
   * @purpose  Abstract base class
   */
  abstract class GenericScriptlet extends Scriptlet {
  
    /**
     * Called by the service method for requests made by GET method.
     *
     * @param   web.scriptlet.ScriptletRequest request
     * @param   web.scriptlet.ScriptletResponse response
     */
    protected function doGet(ScriptletRequest $request, ScriptletResponse $response) {
      $response->sendError(400, 'Method "GET" not supported');
    }

    /**
     * Called by the service method for requests made by HEAD method.
     *
     * @param   web.scriptlet.ScriptletRequest request
     * @param   web.scriptlet.ScriptletResponse response
     */
    protected function doHead(ScriptletRequest $request, ScriptletResponse $response) {
      $response->sendError(400, 'Method "HEAD" not supported');
    }

    /**
     * Called by the service method for requests made by POST method.
     *
     * @param   web.scriptlet.ScriptletRequest request
     * @param   web.scriptlet.ScriptletResponse response
     */
    protected function doPost(ScriptletRequest $request, ScriptletResponse $response) {
      $response->sendError(400, 'Method "POST" not supported');
    }

    /**
     * Service a request
     *
     * @param   web.scriptlet.ScriptletRequest request
     * @param   web.scriptlet.ScriptletResponse response
     * @throws  web.scriptlet.ScriptletException to indicate fatal error situations
     */
    public function service(ScriptletRequest $request, ScriptletResponse $response) {
      $response->setRequest($request);
      
      // Need to use dynamic invocation here instead of reflection API because the
      // latter does not allow calling protected methods, not even if the calling 
      // context is correct.
      $target= 'do'.$request->getMethod();
      if (!method_exists($this, $target)) {
        throw new ScriptletException('Illegal request method '.$target, NULL);
      }
      $this->{$target}($request, $response);
    }
  }
?>
