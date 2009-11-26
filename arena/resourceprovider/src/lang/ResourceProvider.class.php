<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.URL');

  /**
   * Provides a resource through a scheme.
   *
   * @see      lang.ClassLoader
   * @purpose  Provide schemes that resolve resources
   */
  class ResourceProvider extends Object {
    protected static
      $instances  = array();

    protected
      $resource   = NULL,
      $scheme     = NULL,
      $loader     = NULL;

    /**
     * Bind instance to protocol. Takes optional classloader that is
     * then used to resolve file requests
     *
     * @param   string scheme
     * @param   IClassLoader cl default NULL
     * @return  lang.SchemeResourceProvider
     */
    public static function bind($scheme, IClassLoader $cl= NULL) {
      if (NULL === $cl) $cl= ClassLoader::getDefault();
      self::$instances[$scheme]= create(new self())->bindInstance($scheme, $cl);
      return self::$instances[$scheme];
    }

    /**
     * Unbind instance
     *
     * @param   string scheme
     */
    public static function unbind($scheme) {
      self::forScheme($scheme)->unbindInstance();
      unset(self::$instances[$scheme]);
    }

    /**
     * Retrieve instance for given path
     *
     * @param   string path
     * @return  lang.SchemeResourceProvider
     */
    public static function forAny($path) {
      if (FALSE !== strpos($path, '://')) $path= substr($path, 0, strpos($path, '://'));
      return self::forScheme($path);
    }

    /**
     * Retrieve instance for given scheme
     *
     * @param   string scheme
     * @return  lang.SchemeResourceProvider
     * @throws  lang.IllegalArgumentException if scheme is not known
     */
    public static function forScheme($scheme) {
      if (!isset(self::$instances[$scheme])) throw new IllegalArgumentException(
        'Scheme "'.$scheme.'" not known.'
      );

      return self::$instances[$scheme];
    }

    /**
     * Perform binding
     *
     * @param   string scheme
     * @param   lang.IClassLoader cl
     * @return  lang.SchemeResourceProvider
     */
    protected function bindInstance($scheme, IClassLoader $cl) {
      if (FALSE === stream_wrapper_register($scheme, __CLASS__)) throw new IllegalStateException(
        'Scheme '.$scheme.' is already bound'
      );

      $this->scheme= $scheme;
      $this->loader= $cl;
      return $this;
    }

    /**
     * Perform unbinding
     *
     */
    protected function unbindInstance() {
      stream_wrapper_unregister($this->scheme);
    }

    /**
     * Opens new stream
     *
     * @param   string path
     * @param   string mode
     * @param   int options
     * @param   &string opened_path
     * @return  bool
     */
    public function stream_open($path, $mode, $options, &$opened_path) {
      if ($mode !== 'r' && $mode !== 'rb') return FALSE;

      $instance= self::forAny($path);
      $this->scheme= $instance->getScheme();
      $this->loader= $instance->getLoader();

      $this->resource= $this->getLoader()->getResourceAsStream($this->translatePath($path));
      $this->resource->open(FILE_MODE_READ);

      return TRUE;
    }
    
    /**
     * Retrieve scheme
     *
     * @return  string
     */
    protected function getScheme() {
      return $this->scheme;
    }

    /**
     * Retrieve associated loader
     *
     * @return  lang.IClassLoader
     */
    protected function getLoader() {
      return $this->loader;
    }

    /**
     * Translate module name into path
     *
     * @param   string path
     * @return  string
     */
    public function translatePath($path) {

      // Shortcut
      if (1 === sscanf($path, 'res://%s', $file)) return $file;
      throw new IllegalArgumentException('Invalid resource expression: "'.$path.'"');
    }
    
    /**
     * Close stream
     *
     */
    public function stream_close() {
      $this->resource->close();
      $this->resource= NULL;
    }
    
    /**
     * Read from stream
     *
     * @param   int count
     * @return  string
     */
    public function stream_read($count) {
      return $this->resource->read($count);
    }
    
    /**
     * Write to stream. Unsupported
     *
     * @param   string data
     * @return  int
     */
    public function stream_write($data) {
      raise('lang.MethodNotImplementedException', 'Not writeable.', __METHOD__);
    }
    
    /**
     * Checks for end-of-file
     *
     * @return  bool
     */
    public function stream_eof() {
      return $this->resource->eof();
    }
    
    /**
     * Retrieve current file pointer position
     *
     * @return  int
     */
    public function stream_tell() {
      return $this->resource->tell();
    }
    
    /**
     * Seek to given offset
     *
     * @param   int offset
     * @param   int whence
     */
    public function stream_seek($offset, $whence) {
      $this->resource->seek($offset);
    }
    
    /**
     * Flush stream
     *
     */
    public function stream_flush() {
      // NOOP
    }
    
    /**
     * Callback for stat() requests
     *
     * @param   string path
     * @param   int flags
     * @return  <string,int>[]
     */
    public function url_stat($path, $flags) {
      $instance= self::forAny($path);

      if (!$instance->getLoader()->providesResource($instance->translatePath($path))) {
        return FALSE;
      }

      $hdl= $instance->getLoader()->getResourceAsStream($instance->translatePath($path));
      return array(
        'dev'   => 0,
        'ino'   => 0,
        'mode'  => 0444,
        'nlink' => 0,
        'uid'   => 1,
        'gid'   => 1,
        'rdev'  => 0,
        'size'  => $hdl->size(),
        'atime' => 0,
        'mtime' => 0,
        'ctime' => 0,
      );
    }                            
  }
?>
