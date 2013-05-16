<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.OutputStream', 'web.scriptlet.ScriptletResponse');

  /**
   * Output stream that commits the response on the first method
   * call to any of its write, flush or close methods.
   *
   * @see      xp://io.streams.OutputStream
   * @purpose  Scriptlet output
   */
  class ScriptletOutputStream extends Object implements OutputStream {
    protected $out, $res, $com;
    
    /**
     * Constructor
     *
     * @param   io.streams.OutputStream out
     * @param   web.scriptlet.ScriptletResponse res
     */
    public function __construct(OutputStream $out, ScriptletResponse $res) {
      $this->out= $out;
      $this->res= $res;
    }

    /**
     * Write a string
     *
     * @param   mixed arg
     */
    public function write($arg) {
      if (!$this->com) {
        $this->com= TRUE;
        $this->res->commit();
      }
      $this->out->write($arg);
    }

    /**
     * Flush this buffer
     *
     */
    public function flush() {
      if (!$this->com) {
        $this->com= TRUE;
        $this->res->commit();
      }
      $this->out->flush();
    }

    /**
     * Close this buffer
     *
     */
    public function close() {
      if (!$this->com) {
        $this->com= TRUE;
        $this->res->commit();
      }
      $this->out->close();
    }
  }
?>
