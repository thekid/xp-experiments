<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.wrapper';

  uses(
    'peer.URL'
  );

  /**
   * abstract ide Wrapper
   *
   * @purpose IDE
   */
  abstract class xp·ide·wrapper·Wrapper extends Object {

    protected
      $in= NULL,
      $out= NULL,
      $err= NULL,
      $ide= NULL;

    /**
     * constructor
     *
     * @param xp.ide.XpIde
     */
    public function __construct(xp·ide·XpIde $ide) {
      $this->ide= $ide;
      $this->in= $this->ide->getIn();
      $this->out= $this->ide->getOut();
      $this->err= $this->ide->getErr();
    }

    /**
     * set input stream
     *
     * @param  io.streams.TextReader in
     */
    public function setIn(TextReader $in) {
      $this->in= $in;
      $this->ide->setIn($this->in);
    }

    /**
     * get input stream
     *
     * @return io.streams.TextReader
     */
    public function getIn() {
      return $this->in;
    }

    /**
     * set output stream
     *
     * @param  io.streams.TextWriter out
     */
    public function setOut(TextWriter $out) {
      $this->out= $out;
      $this->ide->setOut($this->out);
    }

    /**
     * get output stream
     *
     * @return io.streams.TextWriter
     */
    public function getOut() {
      return $this->out;
    }

    /**
     * set error stream
     *
     * @param  io.streams.TextWriter err
     */
    public function setErr(TextWriter $err) {
      $this->err= $err;
      $this->ide->setErr($this->err);
    }

    /**
     * get error stream writer
     *
     * @return io.streams.TextWriter
     */
    public function getErr() {
      return $this->err;
    }
  }
?>
