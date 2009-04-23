<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.compiler.Syntax',
    'xp.compiler.emit.Emitter',
    'xp.compiler.diagnostic.DiagnosticListener',
    'xp.compiler.io.FileManager',
    'io.File'
  );

  /**
   * Compiler
   *
   */
  class Compiler extends Object implements Traceable {
  
    /**
     * Compile a set of files
     *
     * @param   io.File[] files
     * @param   xp.compiler.diagnostic.DiagnosticListener listener
     * @param   xp.compiler.io.FileManager manager
     * @param   xp.compiler.emit.Emitter emitter
     */
    public function compile(array $files, DiagnosticListener $listener, FileManager $manager, Emitter $emitter) {
    
      // Inherit logging
      $emitter->setTrace($this->cat);
    
      // Start run
      $listener->runStarted();
      foreach ($files as $file) {
        $listener->compilationStarted($file);
        $target= $manager->getTarget($file);
        try {
          $manager->write($emitter->emit($manager->parseFile($file), $manager), $target);
          $listener->compilationSucceeded($file, $target, $emitter->messages());
        } catch (ParseException $e) {
          $listener->parsingFailed($file, $e);
        } catch (FormatException $e) {
          $listener->emittingFailed($file, $e);
        } catch (Throwable $e) {
          $listener->compilationFailed($file, $e);
        }
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
