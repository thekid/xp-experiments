<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler';

  uses(
    'io.File',
    'xp.compiler.Compiler',
    'xp.compiler.emit.oel.Emitter',
    'xp.compiler.diagnostic.DefaultDiagnosticListener',
    'xp.compiler.io.FileSource',
    'xp.compiler.io.FileManager',
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
      
      $c= new Compiler();
      
      // Handle arguments
      $files= array();
      $listener= new DefaultDiagnosticListener(Console::$out);
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
          $c->setTrace(Logger::getInstance()->getCategory()->withAppender($appender, $levels));
        } else {
          $files[]= new FileSource(new File($args[$i]));
        }
      }
      
      // Check
      if (empty($files)) {
        Console::$err->writeLine('*** No files given (-? will show usage)');
        exit(2);
      }
      
      // Compile files
      $c->compile($files, $listener, new FileManager(), new xp·compiler·emit·oel·Emitter());
    }
  }
?>
