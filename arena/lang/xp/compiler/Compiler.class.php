<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.compiler.emit.Emitter',
    'xp.compiler.task.CompilationTask',
    'xp.compiler.diagnostic.DiagnosticListener',
    'xp.compiler.io.FileManager',
    'xp.compiler.io.Source',
    'io.File'
  );

  /**
   * Compiler
   *
   */
  class Compiler extends Object implements Traceable {
    protected $cat= NULL;
  
    /**
     * Compile a set of files
     *
     * @param   xp.compiler.io.Source[] sources
     * @param   xp.compiler.diagnostic.DiagnosticListener listener
     * @param   xp.compiler.io.FileManager manager
     * @param   xp.compiler.emit.Emitter emitter
     */
    public function compile(array $sources, DiagnosticListener $listener, FileManager $manager, Emitter $emitter) {
      $emitter->setTrace($this->cat);
      $listener->runStarted();
      foreach ($sources as $source) {
        create(new CompilationTask($source, $listener, $manager, $emitter))->run();
      }
      $listener->runFinished();
    }
    
    /**
     * Set log category for debugging
     *
     * @param   util.log.LogCategory cat
     */
    public function setTrace($cat) {
      $this->cat= $cat;
    }
  }
?>
