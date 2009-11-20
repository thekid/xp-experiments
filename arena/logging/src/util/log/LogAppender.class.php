<?php
/* This class is part of the XP framework
 *
 * $Id: LogAppender.class.php 13756 2009-10-30 11:13:29Z kiesel $
 */

  /**
   * Abstract base class for appenders
   *
   * @see      xp://util.log.LogCategory#addAppender
   * @purpose  Base class
   */
  abstract class LogAppender extends Object {
    protected $layout= NULL;
    
    /**
     * Sets layout
     *
     * @param   util.log.Layout layout
     * @return  util.log.LogAppender
     */
    public function withLayout(util·log·Layout $layout) {
      $this->layout= $layout;
      return $this;
    }

    /**
     * Append data
     *
     * @param   util.log.LoggingEvent event
     */ 
    public abstract function append(LoggingEvent $event);
    
    /**
     * Finalize this appender. This method is called when the logger
     * is shut down. Does nothing in this default implementation.
     *
     */   
    public function finalize() { }
  }
?>
