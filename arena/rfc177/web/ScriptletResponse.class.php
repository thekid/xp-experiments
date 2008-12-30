<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Defines the response sent by the server to the client
   *
   * @purpose  Interface
   */  
  interface ScriptletResponse {

    /**
     * Sets the length of the content body in the response. 
     *
     * @param   int length
     */
    public function setContentLength($length);

    /**
     * Sets the content type of the response being sent to the client.
     *
     * @param   string type
     */
    public function setContentType($type);

    /**
     * Sets the content type of the response being sent to the client.
     *
     * @param   string encoding
     */
    public function setCharacterEncoding($encoding);

    /**
     * Commit this response
     *
     */
    public function commit();

    /**
     * Returns whether the response has been comitted yet.
     *
     * @return  bool
     */
    public function isCommitted();

    /**
     * Gets the output stream
     *
     * @param   io.streams.OutputStream
     */
    public function getOutputStream();

    /**
     * Flushes this response, that is, writes all headers to the outputstream
     *
     */
    public function flush();
    
  }
?>
