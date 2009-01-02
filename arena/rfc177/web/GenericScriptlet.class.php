<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('web.Scriptlet', 'web.http.HttpScriptletRequest', 'web.http.HttpScriptletResponse');

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
   * @see      xp://web.scriptlet
   * @purpose  Abstract base class
   */
  abstract class HttpScriptlet extends Scriptlet {
  
    /**
     * Called by the service method for requests made by GET method.
     *
     * @param   web.http.ScriptletRequest request
     * @param   web.http.ScriptletResponse response
     */
    protected function doGet(HttpScriptletRequest $request, HttpScriptletResponse $response) {
      $response->sendError(400, 'Method "GET" not supported');
    }

    /**
     * Called by the service method for requests made by HEAD method.
     *
     * @param   web.http.ScriptletRequest request
     * @param   web.http.ScriptletResponse response
     */
    protected function doHead(HttpScriptletRequest $request, HttpScriptletResponse $response) {
      $response->sendError(400, 'Method "HEAD" not supported');
    }

    /**
     * Called by the service method for requests made by POST method.
     *
     * @param   web.http.ScriptletRequest request
     * @param   web.http.ScriptletResponse response
     */
    protected function doPost(HttpScriptletRequest $request, HttpScriptletResponse $response) {
      $response->sendError(400, 'Method "POST" not supported');
    }

    /**
     * Service a request
     *
     * @param   web.ScriptletRequest request
     * @param   web.ScriptletResponse response
     * @throws  web.ScriptletException to indicate fatal error situations
     */
    public function service(ScriptletRequest $request, ScriptletResponse $response) {
      try {
        $request= cast($request, 'web.http.HttpScriptletRequest');
        $response= cast($response, 'web.http.HttpScriptletResponse');
      } catch (ClassCastException $e) {
        throw new ScriptletException('Cannot handle non-HTTP request/response', $e);
      }
      
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
