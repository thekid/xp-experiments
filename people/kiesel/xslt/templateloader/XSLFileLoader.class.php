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
  class XSLFileLoader extends Object {
    protected
      $paths        = array(),
      $currentPath  = '';
    
    public function __construct() {
      var_dump(__FUNCTION__);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_open($path, $mode, $options, $opened_path) {
      throw Exception("foo");
      var_dump("being here");
      Console::writeLine('---> stream_open(', $path, ', ', $mode, ', ', $options, ')');
      return FALSE;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_close() {
    
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_read($count) {
    
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_write($data) {
    
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_eof() {
    
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_tell() {
    
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_seek($offset, $whence) {
    
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_flush() {
    
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_stat() {
    
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function url_stat($path, $flags) {
    var_dump(__FUNCTION__, $path, $flags);

    }                            
  }
?>
