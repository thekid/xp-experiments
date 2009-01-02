<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('peer.URL', 'io.streams.InputStream');

  /**
   * Defines the request sent by the client to the server
   *
   * @purpose  Interface
   */  
  interface ScriptletRequest {

    /**
     * Returns input stream
     *
     * @return  io.streams.InputStream
     */
    public function getInputStream();

    /**
     * Gets the length of the request sent by the client.
     *
     * @return  int length
     */
    public function getContentLength();

    /**
     * Gets the content type of the request sent by the client.
     *
     * @return  string type
     */
    public function getContentType();

    /**
     * Gets the content type of the request sent by the client.
     *
     * @return  string encoding
     */
    public function getCharacterEncoding();

    /**
     * Returns a request variable by its name or NULL if there is no such
     * request variable
     *
     * @param   string name Parameter name
     * @param   mixed default default NULL the default value if parameter is non-existant
     * @return  string Parameter value
     */
    public function getParam($name, $default= NULL);

    /**
     * Returns whether the specified request variable is set
     *
     * @param   string name Parameter name
     * @return  bool
     */
    public function hasParam($name);

    /**
     * Gets all request parameters
     *
     * @return  array params
     */
    public function getParams();

    /**
     * Retrieves the requests absolute URI as an URL object
     *
     * @return  peer.URL
     */
    public function getURL();
  }
?>
