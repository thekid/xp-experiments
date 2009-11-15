<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';
  
  uses(
    'xp.ide.Cursor',
    'xp.ide.XpIde',
    'io.Folder',
    'io.streams.TextWriter',
    'io.streams.TextReader',
    'io.streams.ChannelInputStream',
    'io.streams.ChannelOutputStream',
    'lang.XPClass',
    'util.cmd.Console',
    'util.cmd.ParamString'
  );
  
  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·Runner extends Object {

    private static
      $artefacts= array(
        'Cursor'   => 'getCursor',
        'Language' => 'getLanguage',
        'CWD'      => 'getCwd',
      ),
      $in= NULL,
      $out= NULL,
      $err= NULL;

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    public static function main(array $args) {
      $params= new ParamString($args);
      with ($enc= $params->value('stream-encoding', 'se', 'ISO-8859-1')); {
        self::$in= new TextReader(new ChannelInputStream('stdin'), $enc);
        self::$out= new TextWriter(new ChannelOutputStream('stdout'), $enc);
        self::$err= new TextWriter(new ChannelOutputStream('stderr'), $enc);
      }

      try {
        if (2 > sizeOf($args)) return self::usage();

        $wrapper= XPClass::forName('xp.ide.wrapper.'.array_shift($args))->newInstance(new xp·ide·XpIde(self::$in, self::$out, self::$err));
        if (!$wrapper instanceof xp·ide·wrapper·Wrapper) throw new IllegalArgumentException(sprintf('%s does not implement xp·ide·wrapper·Wrapper', $wrapper->getClassName()));

        $action= array_shift($args);
        $actionMethods= array();
        with ($class= $wrapper->getClass()); {
          foreach ($class->getMethods() as $method) {
            if ($method->hasAnnotation('action')) $actionMethods[$method->getAnnotation('action', 'name')]= $method;
          }
          if (!isset($actionMethods[$action])) throw new IllegalArgumentException(sprintf('action %s not found', $action));
        }

        // assemble arguments
        $action_args= array();
        if ($actionMethods[$action]->hasAnnotation('action', 'args')) {
          foreach (explode(',', $actionMethods[$action]->getAnnotation('action', 'args')) as $arg) {
            $arg= trim($arg);
            if (!isset(self::$artefacts[$arg])) throw new IllegalStateException(sprintf('unknown artefact "%s" requested by action "%s"', $arg, $action));
            $action_args[]= call_user_func_array(array(__CLASS__, self::$artefacts[$arg]), array($params));
          }
        }

        call_user_func_array(array($wrapper, $actionMethods[$action]->getName()), $action_args);
      } catch (XPException $e) {
        self::$err->write($e->getMessage());
        return 1;
      }
      return 0;
    }

    /**
     * get cursor
     *
     * @param util.cmd.ParamString params
     * @return xp.ide.Cursor
     */
    public static function getCursor(ParamString $params) {
      return new xp·ide·Cursor(
        $params->value('cursor-position', 'cp'),
        $params->value('cursor-line',     'cl'),
        $params->value('cursor-column',   'cc')
      );
    }

    /**
     * get current working directory
     *
     * @param util.cmd.ParamString params
     * @return io.Folder
     */
    public static function getCwd(ParamString $params) {
      return new Folder($params->value('filesystem-cwd', 'fc'));
    }

    /**
     * get source language
     *
     * @param util.cmd.ParamString params
     * @return xp.ide.lint.language
     */
    public static function getLanguage(ParamString $params) {
      return XPClass::forName('xp.ide.lint.'.ucFirst(strToLower($params->value('language-name', 'ln'))))->newInstance();
    }

    /**
     * Show usage
     */
    public static function usage() {
      Console::$out->writeLine('** Usage: xpide xp.ide.Runner "wrapper" "action" [--stream-encoding] [--cursor-position --cursor-line --cursor-column] [--language-name]');
      Console::$out->writeLine('   - wrapper: a classname from the namespace xp.ide.wrapper (e.g. "Nedit")');
      Console::$out->writeLine('   - action: XpIde action');
      Console::$out->writeLine(' * Stream: parameters to assamble the input stream');
      Console::$out->writeLine('   - stream-encoding (se): input/output/error stream encoding (defaults to ISO-8859-1)');
      Console::$out->writeLine(' * Filesystem: parameters to get the current working dir');
      Console::$out->writeLine('   - filesystem-cwd (fc): current working uri');
      Console::$out->writeLine(' * Cursor: parameters to assamble the cursor');
      Console::$out->writeLine('   - cursor-position (cp): Cursor char position in the text buffer');
      Console::$out->writeLine('   - cursor-line (cl):     Cursor line');
      Console::$out->writeLine('   - cursor-column (cc):   Cursor char position in the line');
      Console::$out->writeLine(' * Language: parameters to assamble the source language');
      Console::$out->writeLine('   - language-name (ln): language name (e.g "php")');
    }

  }
?>
