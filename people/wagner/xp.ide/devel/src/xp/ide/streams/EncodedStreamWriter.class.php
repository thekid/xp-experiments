<?php
/* This file is part of the XP framework's experiments
 *
 * $Id: StringWriter.class.php 13211 2009-07-12 15:13:34Z friebe $
 */
$package= 'xp.ide.streams';

  uses('io.streams.OutputStreamWriter');

  /**
   * A OutputStreamWriter wrapper
   *
   * @purpose  OutputStreamWriter implementation
   */
  class xp·ide·streams·EncodedStreamWriter extends Object implements OutputStreamWriter {

    private
      $out= NULL;

    /**
     * Constructor
     *
     * @param xp.ide.streams.IEncodedOutputStream out
     */
    public function __construct($out) {
      $this->out= $out;
    }
    
    /**
     * Return underlying output stream
     *
     * @return xp.ide.streams.IEncodedOutputStream
     */
    public function getStream() {
      return $this->out;
    }

    /**
     * Return underlying output stream
     *
     * @param   xp.ide.streams.IEncodedOutputStream out
     */
    public function setStream(xp·ide·streams·IEncodedOutputStream $out) {
      $this->out= $out;
    }

    /**
     * Creates a string representation of this writer
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName()."@{\n  ".$this->out->toString()."\n}";
    }

    /**
     * Flush output buffer
     *
     */
    public function flush() {
      $this->out->flush();
    }

    /**
     * Print arguments
     *
     * @param   mixed* args
     */
    public function write() {
      $a= func_get_args();
      foreach ($a as $arg) {
        if ($arg instanceof Generic) {
          $this->out->write($this->encode($arg->toString()));
        } else if (is_array($arg)) {
          $this->out->write($this->encode(xp::stringOf($arg)));
        } else {
          $this->out->write($this->encode($arg));
        }
      }
    }
    
    /**
     * Print arguments and append a newline
     *
     * @param   mixed* args
     */
    public function writeLine() {
      $a= func_get_args();
      foreach ($a as $arg) {
        if ($arg instanceof Generic) {
          $this->out->write($this->encode($arg->toString()));
        } else if (is_array($arg)) {
          $this->out->write($this->encode(xp::stringOf($arg)));
        } else {
          $this->out->write($this->encode($arg));
        }
      }
      $this->out->write("\n");
    }
    
    /**
     * Print a formatted string
     *
     * @param   string format
     * @param   mixed* args
     * @see     php://writef
     */
    public function writef() {
      $a= func_get_args();
      $fstr= $this->encode(array_shift($a));
      foreach ($a as &$p) $p= $this->encode($p);
      $this->out->write(vsprintf($fstr, $a));
    }

    /**
     * Print a formatted string and append a newline
     *
     * @param   string format
     * @param   mixed* args
     */
    public function writeLinef() {
      $a= func_get_args();
      $fstr= $this->encode(array_shift($a));
      foreach ($a as &$p) $p= $this->encode($p);
      $this->out->write(vsprintf($fstr, $a)."\n");
    }

    /**
     * encode a string
     *
     * @param   string str
     */
    private function encode($str) {
      if (xp·ide·streams·IEncodedOutputStream::ENCODING_NONE == $this->out->getEncoding()) return $str;
      if ('ISO-8859-1' == $this->out->getEncoding()) return $str;
      return iconv('ISO-8859-1', $this->out->getEncoding(), $str);
    }
  }
?>
