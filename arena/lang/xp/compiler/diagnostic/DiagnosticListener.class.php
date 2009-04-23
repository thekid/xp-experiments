<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  /**
   * Classes implementing this interface listen to the compilation 
   * process.
   *
   */
  interface DiagnosticListener {

    /**
     * Called when compilation starts
     *
     * @param   io.File src
     */
    public function compilationStarted(File $src);
  
    /**
     * Called when a compilation finishes successfully.
     *
     * @param   io.File src
     * @param   io.File compiled
     * @param   string[] messages
     */
    public function compilationSucceeded(File $src, File $compiled, array $messages= array());
    
    /**
     * Called when parsing fails
     *
     * @param   io.File src
     * @param   text.parser.generic.ParseException reason
     */
    public function parsingFailed(File $src, ParseException $reason);

    /**
     * Called when emitting fails
     *
     * @param   io.File src
     * @param   lang.FormatException reason
     */
    public function emittingFailed(File $src, FormatException $reason);

    /**
     * Called when compilation fails
     *
     * @param   io.File src
     * @param   lang.Throwable reason
     */
    public function compilationFailed(File $src, Throwable $reason);

    /**
     * Called when a run starts.
     *
     */
    public function runStarted();
    
    /**
     * Called when a test run finishes.
     *
     */
    public function runFinished();
  }
?>
