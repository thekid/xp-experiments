<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.wrapper';

  uses(
    'xp.ide.IXpIde',
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
     * @param xp.ide.IXpIde
     */
    public function __construct(xp·ide·IXpIde $ide) {
      $this->ide= $ide;
      $this->in= $this->ide->getIn();
      $this->out= $this->ide->getOut();
      $this->err= $this->ide->getErr();
    }

    /**
     * set input stream
     *
     * @param  xp.ide.streams.IEncodedInputStream in
     */
    public function setIn(xp·ide·streams·IEncodedInputStream $in) {
      $this->in= $in;
      $this->ide->setIn($this->in);
    }

    /**
     * get input stream
     *
     * @return xp.ide.streams.IEncodedInputStream
     */
    public function getIn() {
      return $this->in;
    }

    /**
     * set output stream
     *
     * @param  xp.ide.streams.IEncodedOutputStream out
     */
    public function setOut(xp·ide·streams·IEncodedOutputStream $out) {
      $this->out= $out;
      $this->ide->setOut($this->out);
    }

    /**
     * get output stream
     *
     * @return xp.ide.streams.IEncodedOutputStream
     */
    public function getOut() {
      return $this->out;
    }

    /**
     * set error stream
     *
     * @param  xp.ide.streams.IEncodedOutputStream err
     */
    public function setErr(xp·ide·streams·IEncodedOutputStream $err) {
      $this->err= $err;
      $this->ide->setErr($this->err);
    }

    /**
     * get error stream
     *
     * @return xp.ide.streams.IEncodedOutputStream
     */
    public function getErr() {
      return $this->err;
    }

  }
?>
