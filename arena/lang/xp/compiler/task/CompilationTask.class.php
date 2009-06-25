<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.compiler.Syntax',
    'xp.compiler.emit.Emitter',
    'xp.compiler.types.TaskScope',
    'xp.compiler.diagnostic.DiagnosticListener',
    'xp.compiler.io.Source',
    'xp.compiler.io.FileManager',
    'io.File'
  );

  /**
   * Represents a compilation task
   *
   * @see   xp://xp.compiler.Compiler#compile
   */
  class CompilationTask extends Object {
    protected
      $source     = NULL,
      $manager    = NULL,
      $listener   = NULL,
      $emitter    = NULL;

    /**
     * Constructor
     *
     * @param   xp.compiler.io.Source source
     * @param   xp.compiler.diagnostic.DiagnosticListener listener
     * @param   xp.compiler.io.FileManager manager
     * @param   xp.compiler.emit.Emitter emitter
     */
    public function __construct(xp·compiler·io·Source $source, DiagnosticListener $listener, FileManager $manager, Emitter $emitter) {
      $this->source= $source;
      $this->manager= $manager;
      $this->listener= $listener;
      $this->emitter= $emitter;
    }
    
    /**
     * Returns a subtask (overloaded)
     *
     * @param   var arg either a xp.compiler.io.Source or a fully qualified class name
     * @return  xp.compiler.task.CompilationTask
     * @throws  lang.IllegalArgumentException for argument type mismatches
     */
    public function newSubTask($arg) {
      if ($arg instanceof xp·compiler·io·Source) {
        $source= $arg;
      } else if (is_string($arg)) {
        $source= $this->manager->locateClass($arg);
      } else {
        throw new IllegalArgumentException('Expected either a string or a Source object');
      }
      $self= new self($source, $this->listener, $this->manager, $this->emitter);
      return new self($source, $this->listener, $this->manager, $this->emitter);
    }
    
    /**
     * Run this task and emit compiled code using a given emitter
     *
     * @return  var
     */
    public function run() {
      $scope= new TaskScope($this);
      
      // Start run
      $this->listener->compilationStarted($this->source);
      $target= $this->manager->getTarget($this->source);
      $ast= NULL;
      try {
        $ast= $this->manager->parseFile($this->source);
        $result= $this->emitter->emit($ast, $scope);
        $this->manager->write($result, $target);
        $this->listener->compilationSucceeded($this->source, $target, $this->emitter->messages());
      } catch (ParseException $e) {
        $this->listener->parsingFailed($this->source, $e);
      } catch (FormatException $e) {
        $this->listener->emittingFailed($this->source, $e);
      } catch (Throwable $e) {
        $this->listener->compilationFailed($this->source, $e);
      }
      
      return $ast;    // FIXME: Should return compiled type
    }
  }
?>
