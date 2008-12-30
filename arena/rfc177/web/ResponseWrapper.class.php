<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('web.ScriptletResponse');

  /**
   * Wraps a response - that is, delegates all calls to the wrapped response
   * object.
   *
   * @purpose  Response implementation
   */  
  abstract class ResponseWrapper extends Object implements ScriptletResponse {
    protected $wrapped= NULL;
      
    /**
     * Constructor
     *
     * @param   web.ScriptletResponse wrapped
     */
    public function __construct(ScriptletResponse $wrapped) {
      $this->wrapped= $wrapped;
    }

    /**
     * Sets the length of the content body in the response. 
     *
     * @param   int length
     */
    public function setContentLength($length) {
      return $this->wrapped->setContentLength($length);
    }

    /**
     * Sets the content type of the response being sent to the client.
     *
     * @param   string type
     */
    public function setContentType($type) {
      return $this->wrapped->setContentType($type);
    }

    /**
     * Sets the content type of the response being sent to the client.
     *
     * @param   string encoding
     */
    public function setCharacterEncoding($encoding) {
      return $this->wrapped->setCharacterEncoding($encoding);
    }

    /**
     * Commits this response
     *
     * @return  bool
     */
    public function commit() {
      $this->wrapped->commit();
    }

    /**
     * Returns whether the response has been comitted yet.
     *
     * @return  bool
     */
    public function isCommitted() {
      return $this->wrapped->isCommitted();
    }

    /**
     * Gets the output stream
     *
     * @param   io.streams.OutputStream
     */
    public function getOutputStream() {
      return $this->wrapped->getOutputStream();
    }

    /**
     * Flushes this response, that is, writes all headers to the outputstream
     *
     */
    public function flush() {
      return $this->wrapped->flush();
    }

    /**
     * Returns a string representation of this response wrapper
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(->'.$this->wrapped->toString().')';
    }
  }
?>
