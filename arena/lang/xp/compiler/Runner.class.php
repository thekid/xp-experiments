<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler';

  uses(
    'io.File',
    'io.streams.FileInputStream',
    'xp.compiler.emit.oel.Emitter',
    'xp.compiler.DefaultListener',
    'util.log.Logger',
    'util.log.LogAppender'
  );

  /**
   * XP Compiler
   *
   * Usage:
   * <pre>
   * $ xcc [options] [file [file [... ]]]
   * </pre>
   *
   * Options is one of:
   * <ul>
   *   <li>-cp [path]: 
   *     Add path to classpath
   *   </li>
   *   <li>-t [level[,level[...]]]:
   *     Set trace level (all, none, info, warn, error, debug)
   *   </li>
   * </ul>
   *
   * @purpose  Runner
   */
  class xp·compiler·Runner extends Object {
  
    /**
     * Converts api-doc "markup" to plain text w/ ASCII "art"
     *
     * @param   string markup
     * @return  string text
     */
    protected static function textOf($markup) {
      $line= str_repeat('=', 72);
      return strip_tags(preg_replace(array(
        '#<pre>#', '#</pre>#', '#<li>#',
      ), array(
        $line, $line, '* ',
      ), trim($markup)));
    }

    /**
     * Shows usage and exits
     *
     */
    protected function showUsage() {
      Console::$err->writeLine(self::textOf(XPClass::forName(xp::nameOf(__CLASS__))->getComment()));
      exit(1);
    }
    
    /**
     * Entry point method
     *
     * @param   string[] args
     */
    public static function main(array $args) {
      if (empty($args)) self::showUsage();
      
      $emitter= new xp·compiler·emit·oel·Emitter();
      $syntax= Package::forName('xp.compiler.syntax');
      $syntaxes= array();
      
      // Handle arguments
      $files= array();
      $listener= new DefaultListener(Console::$out);
      for ($i= 0, $s= sizeof($args); $i < $s; $i++) {
        if ('-?' === $args[$i] || '--help' === $args[$i]) {
          self::showUsage();
        } else if ('-cp' === $args[$i]) {
          ClassLoader::registerPath($args[++$i]);
        } else if ('-t' === $args[$i]) {
          $levels= LogLevel::NONE;
          foreach (explode(',', $args[++$i]) as $level) {
            $levels |= LogLevel::named($level);
          }
          $appender= newinstance('util.log.LogAppender', array(), '{
            public function append() {
              $args= func_get_args();
              Console::$err->writeLine("  ", implode(" ", array_map(array($this, "varSource"), $args)));
            }
          }');
          $emitter->setTrace(Logger::getInstance()->getCategory()->withAppender($appender, $levels));
        } else {
          $files[]= new File($args[$i]);
        }
      }
      
      // Check
      if (empty($files)) {
        Console::$err->writeLine('*** No files given (-? will show usage)');
        exit(2);
      }
      
      // Compile files
      $listener->runStarted();
      $status= array();
      foreach ($files as $file) {
        $listener->compilationStarted($file);
        $ext= $file->getExtension();
        try {
          if (!isset($syntaxes[$ext])) {
            $syntaxes[$ext]= array(
              'parser' => $syntax->getPackage($ext)->loadClass('Parser')->newInstance(),
              'lexer'  => $syntax->getPackage($ext)->loadClass('Lexer')
            );
          }
          $ast= $syntaxes[$ext]['parser']->parse($syntaxes[$ext]['lexer']->newInstance(
            new FileInputStream($file),
            $file->getURI()
          ));
          $r= $emitter->emit($ast);
          $listener->compilationSucceeded($file, $r);
        } catch (ParseException $e) {
          $listener->parsingFailed($file, $e);
        } catch (FormatException $e) {
          $listener->emittingFailed($file, $e);
        } catch (Throwable $e) {
          $listener->compilationFailed($file, $e);
        }
      }
      $listener->runFinished();
      exit(0);
    }
  }
?>
