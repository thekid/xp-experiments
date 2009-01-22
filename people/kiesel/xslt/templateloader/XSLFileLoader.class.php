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
      $currentPath  = '';
    
    private
      $resource= NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_open($path, $mode, $options, $opened_path) {
      var_dump(__FUNCTION__.': '.$path);
      if ($mode !== 'r' && $mode !== 'rb') return FALSE;
    
      $path= substr($path, 6);
      // TBI: Should be cloned, so we can open file multiple times?
      $this->resource= ClassLoader::getDefault()->getResourceAsStream($path);
      $this->resource->open(FILE_MODE_READ);
      
      // TBI: Error reporint: exceptions or trigger_error()?
      // TBI: Evaluate STREAM_USE_PATH in options and set opened_path
      return TRUE;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_close() {
      $this->resource->close();
      
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_read($count) {
      return $this->resource->read($count);
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
      return $this->resource->eof();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_tell() {
      return $this->resource->tell();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function stream_seek($offset, $whence) {
      $this->resource->seek($offset);
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
      // Remove xsl:// from path
      $path= substr($path, 6);
      $cl= ClassLoader::getDefault()->findResource($path);
      if ($cl instanceof null) return FALSE;

      // Return array to indicate existance
      return array();
    }                            
  }
?>
