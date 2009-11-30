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
    'xp.compiler.CompilationException',
    'xp.compiler.io.Source',
    'xp.compiler.io.FileManager',
    'lang.ElementNotFoundException',
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
     * Locate a package
     *
     * @param   string name
     * @return  string qualified
     * @throws  lang.ElementNotFoundException
     */
    public function locatePackage($name) {
      if (ClassLoader::getDefault()->providesPackage($name) || $this->manager->findPackage($name)) {
        return $name;
      }
      throw new ElementNotFoundException('Could not locate package '.$name);
    }
    
    /**
     * Locate a class
     *
     * @param   string[] packages
     * @param   string name
     * @return  string qualified
     * @throws  lang.ElementNotFoundException
     */
    public function locateClass($packages, $local) {
      $cl= ClassLoader::getDefault();
      foreach ($packages as $package) {
        $qualified= $package.'.'.$local;
        if (!$cl->providesClass($qualified) && !$this->manager->findClass($qualified)) continue;
        return $qualified;
      }
      throw new ElementNotFoundException('Could not locate class '.$local.' in '.xp::stringOf($packages));
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
        $source= $this->manager->findClass($arg);
      } else {
        throw new IllegalArgumentException('Expected either a string or a Source object');
      }
      return new self($source, $this->listener, $this->manager, $this->emitter);
    }
    
    /**
     * Run this task and emit compiled code using a given emitter
     *
     * @return  xp.compiler.types.Types
     * @throws  xp.compiler.CompilationException
     */
    public function run() {
      $scope= new TaskScope($this);
      
      // Start run
      $this->listener->compilationStarted($this->source);
      try {
        $result= $this->emitter->emit($this->manager->parseFile($this->source), $scope);
        $target= $this->manager->getTarget($result->type(), $this->source);
        $this->manager->write($result, $target);
        $this->listener->compilationSucceeded($this->source, $target, $this->emitter->messages());
      } catch (ParseException $e) {
        $this->listener->parsingFailed($this->source, $e);
        throw new CompilationException('Parse error', $e);
      } catch (FormatException $e) {
        $this->listener->emittingFailed($this->source, $e);
        throw new CompilationException('Emitting error', $e);
      } catch (IOException $e) {
        $this->listener->compilationFailed($this->source, $e);
        throw new CompilationException('I/O error', $e);
      } catch (Throwable $e) {
        $this->listener->compilationFailed($this->source, $e);
        throw new CompilationException('Unknown error', $e);
      }
      
      return $result->type();
    }
  }
?>
