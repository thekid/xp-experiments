<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  /**
   * The log category is the interface to be used. All logging information
   * is sent to a log category via one of the info, warn, error, debug 
   * methods which accept any number of arguments of any type (or 
   * their *f variants which use sprintf).
   *
   * Basic example:
   * <code>
   *   $l= Logger::getInstance();
   *   $cat= $l->getCategory();
   *   $cat->addAppender(new ConsoleAppender());
   *
   *   // ...
   *   $cat->info('Starting work at', Date::now());
   *
   *   // ...
   *   $cat->debugf('Processing %d rows took %.3f seconds', $rows, $delta);
   *
   *   try(); {
   *     // ...
   *   } if (catch('SocketException', $e)) {
   *     $cat->warn('Caught', $e);
   *   }
   * </code>
   *
   * @purpose  Base class
   */
  class LogCategory extends Object {
    const
      LOGGER_FLAG_INFO = 0x0001,
      LOGGER_FLAG_WARN = 0x0002,
      LOGGER_FLAG_ERROR = 0x0004,
      LOGGER_FLAG_DEBUG = 0x0008,
      LOGGER_FLAG_ALL = LOGGER_FLAG_INFO | LOGGER_FLAG_WARN | LOGGER_FLAG_ERROR | LOGGER_FLAG_DEBUG;

    public 
      $_appenders= array(),
      $_indicators= array(
        LOGGER_FLAG_INFO        => 'info',
        LOGGER_FLAG_WARN        => 'warn',
        LOGGER_FLAG_ERROR       => 'error',
        LOGGER_FLAG_DEBUG       => 'debug'
      );
      
    public
      $flags,
      $identifier,
      $dateformat,
      $format;

    /**
     * Constructor
     *
     * @access  public
     * @param   string identifier
     * @param   string format 
     * @param   string dateformat
     * @param   int flags
     */
    public function __construct($identifier, $format, $dateformat, $flags= LOGGER_FLAG_ALL) {
      $this->identifier= $identifier;
      $this->format= $format;
      $this->dateformat= $dateformat;
      $this->flags= $flags;
      $this->_appenders= array();
      
    }

    /**
     * Sets the flags (what should be logged). Note that you also
     * need to add an appender for a category you want to log.
     *
     * @access  public
     * @param   int flags bitfield with flags (LOGGER_FLAG_*)
     */
    public function setFlags($flags) {
      $this->flags= $flags;
    }
    
    /**
     * Gets flags
     *
     * @access  public
     * @return  int flags
     */
    public function getFlags() {
      return $this->flags;
    }
    
    /**
     * Private helper function
     *
     * @access  private
     */
    private function callAppenders() {
      $args= func_get_args();
      $flag= $args[0];
      if (!($this->flags & $flag)) return;
      
      $args[0]= sprintf(
        $this->format,
        date($this->dateformat),
        $this->identifier,
        $this->_indicators[$flag]
      );
      
      foreach (array_keys($this->_appenders) as $appflag) {
        if (!($flag & $appflag)) continue;
        foreach (array_keys($this->_appenders[$appflag]) as $idx) {
          call_user_func_array(
            array(&$this->_appenders[$appflag][$idx], 'append'),
            $args
          );
        }
      }
    }
    
    /**
     * Finalize
     *
     * @access  public
     */
    public function finalize() {
      foreach ($this->_appenders as $flags => $appenders) {
        foreach (array_keys($appenders) as $idx) {
          $appenders[$idx]->finalize();
        }
      }
    }
    
    /**
     * Adds an appender for the given log categories. Use logical OR to 
     * combine the log types or use LOGGER_FLAG_ALL (default) to log all 
     * types.
     *
     * @access  public
     * @param   &util.log.LogAppender appender The appender object
     * @param   int flag default LOGGER_FLAG_ALL
     * @return  &util.log.LogAppender the appender added
     */
    public function addAppender(&$appender, $flag= LOGGER_FLAG_ALL) {
      $this->_appenders[$flag][]= $appender;
      return $appender;
    }

    /**
     * Appends a log of type info. Accepts any number of arguments of
     * any type. 
     *
     * The common rule (though up to each appender on how to realize it)
     * for serialization of an argument is:
     *
     * <ul>
     *   <li>For XP objects, the toString() method will be called
     *       to retrieve its representation</li>
     *   <li>Strings are printed directly</li>
     *   <li>Any other type is serialized using var_export()</li>
     * </ul>
     *
     * Note: This also applies to warn(), error() and debug().
     *
     * @access  public
     * @param   mixed* args
     */
    public function info() {
      $args= func_get_args();
      array_unshift($args, LOGGER_FLAG_INFO);
      call_user_func_array(
        array(&$this, 'callAppenders'),
        $args
      );
    }

    /**
     * Appends a log of type info in sprintf-style. The first argument
     * to this method is the format string, containing sprintf-tokens,
     * the rest of the arguments are used as argument to sprintf. 
     *
     * Note: This also applies to warnf(), errorf() and debugf().
     *
     * @see     php://sprintf
     * @access  public
     * @param   string format 
     * @param   mixed* args
     */
    public function infof() {
      $args= func_get_args();
      self::callAppenders(
        LOGGER_FLAG_INFO,
        vsprintf($args[0], array_slice($args, 1))
      );
    }

    /**
     * Appends a log of type warn
     *
     * @access  public
     * @param   mixed* args
     */
    public function warn() {
      $args= func_get_args();
      array_unshift($args, LOGGER_FLAG_WARN);
      call_user_func_array(
        array(&$this, 'callAppenders'),
        $args
      );
    }

    /**
     * Appends a log of type info in printf-style
     *
     * @access  public
     * @param   string format 
     * @param   mixed* args
     */
    public function warnf() {
      $args= func_get_args();
      self::callAppenders(
        LOGGER_FLAG_WARN,
        vsprintf($args[0], array_slice($args, 1))
      );
    }

    /**
     * Appends a log of type error
     *
     * @access  public
     * @param   mixed* args
     */
    public function error() {
      $args= func_get_args();
      array_unshift($args, LOGGER_FLAG_ERROR);
      call_user_func_array(
        array(&$this, 'callAppenders'),
        $args
      );
    }

    /**
     * Appends a log of type info in printf-style
     *
     * @access  public
     * @param   string format 
     * @param   mixed* args
     */
    public function errorf() {
      $args= func_get_args();
      self::callAppenders(
        LOGGER_FLAG_ERROR,
        vsprintf($args[0], array_slice($args, 1))
      );
    }

    /**
     * Appends a log of type debug
     *
     * @access  public
     * @param   mixed* args
     */
    public function debug() {
      $args= func_get_args();
      array_unshift($args, LOGGER_FLAG_DEBUG);
      call_user_func_array(
        array(&$this, 'callAppenders'),
        $args
      );
    }
 
    /**
     * Appends a log of type info in printf-style
     *
     * @access  public
     * @param   string format format string
     * @param   mixed* args
     */
    public function debugf() {
      $args= func_get_args();
      self::callAppenders(
        LOGGER_FLAG_DEBUG,
        vsprintf($args[0], array_slice($args, 1))
      );
    }
   
    /**
     * Appends a separator (a "line" consisting of 72 dashes)
     *
     * @access  public
     */
    public function mark() {
      self::callAppenders(
        LOGGER_FLAG_INFO, 
        str_repeat('-', 72)
      );
    }
  }
?>
