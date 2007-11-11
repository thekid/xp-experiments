<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class Instrumentation extends Object {
    public static $t= NULL;

    static function __static() {
      stream_wrapper_register('instrument', __CLASS__);
      xp::$instrument= 'instrument://%2$s|%1$s';
    }

    /**
     * Stream wrapper open() implementation
     *
     * @param   string path "instrument://" classname "|" uri
     * @param   string mode
     * @param   int options
     * @param   string opened_path
     * @return  bool
     */
    function stream_open($path, $mode, $options, $opened_path) {
      sscanf($path, 'instrument://%[^|]|%[^$]', $this->class, $uri);
      sscanf(xp::$registry['classloader.'.$this->class], '%[^:]://%[^$]', $cl, $argument);
      if (NULL === ($this->bytes= self::$t->transform(call_user_func(array(xp::reflect($cl), 'instanceFor'), $argument), $this->class))) {
        $this->bytes= file_get_contents($uri);
      }
      $this->length= strlen($this->bytes);
      $this->offset= 0;
      return TRUE;
    }
    
    /**
     * Stream wrapper read() implementation
     *
     * @param   int count
     * @return  string
     */
    function stream_read($count) {
      $bytes= substr($this->bytes, $this->offset, $count);
      $this->offset+= $count;
      return $bytes;
    }
    
    /**
     * Stream wrapper eof() implementation
     *
     * @return  bool
     */
    function stream_eof() {
      return $this->offset >= $this->length;
    }
    
  }
?>
