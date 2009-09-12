<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.Reader');

  /**
   * Reads text from an underlying input stream.
   *
   */
  class TextReader extends Reader {
    protected $charset= '';
    protected $buf= '';
  
    /**
     * Constructor. Creates a new TextReader on an underlying input
     * stream with a given charset.
     *
     * @param   io.streams.InputStream stream
     * @param   string charset the charset the stream is encoded in.
     */
    public function __construct(InputStream $stream, $charset) {
      parent::__construct($stream);
      $this->charset= $charset;
    }
  
    /**
     * Read a number of bytes
     *
     * @param   int size default 8192
     * @return  string NULL when end of data is reached
     */
    public function read($size= 8192) {
      if (0 === $size) return '';
      while (strlen($this->buf) < $size && $this->stream->available()) {
        if (NULL === ($read= $this->stream->read(512))) break;
        $this->buf.= $read;
      }
      $chunk= substr($this->buf, 0, $size);
      $this->buf= substr($this->buf, $size);
      return FALSE === $chunk ? NULL : $chunk;
    }
    
    /**
     * Read an entire line
     *
     * @return  string NULL when end of data is reached
     */
    public function readLine() {
      if (NULL === ($c= $this->read(1))) return NULL;
      $line= '';
      do {
        if ("\r" === $c) {
          $n= $this->read(1);
          if ("\n" !== $n) $this->buf= $n.$this->buf;
          return $line;
        } else if ("\n" === $c) {
          return $line;
        }
        $line.= $c;
      } while (NULL !== ($c= $this->read(1)));
      return $line;
    }
  }
?>
