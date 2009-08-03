<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';
  
  uses(
    'lang.XPClass',
    'util.cmd.Console',
    'io.streams.ChannelInputStream',
    'xp.ide.Cursor',
    'util.cmd.ParamString',
    'xp.ide.XpIde'
  );
  
  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·Runner extends Object {

    private static
      $artefacts= array(
        'Cursor'      => 'getCursor',
        'InputStream' => 'getInputStream',
        'Language'    => 'getLanguage',
      );

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    public static function main(array $args) {
      if (2 > sizeOf($args)) return self::usage();

      $inst= new xp·ide·XpIde();
      $class= $inst->getClass();

      $proxy= XPClass::forName('xp.ide.proxy.'.array_shift($args))->newInstance($inst);
      if (!$proxy instanceof xp·ide·IXpIde) throw new IllegalArgumentException(sprintf('%s does not implement xp·ide·IXpIde', $proxy->getClassName()));

      $action= array_shift($args);

      $params= new ParamString($args);
      $encoding= $params->value('encoding', 'e', 'UTF-8');

      $actionMethods= array();
      foreach ($class->getMethods() as $method) {
        if ($method->hasAnnotation('action')) $actionMethods[$method->getAnnotation('action', 'name')]= $method;
      }
      if (!isset($actionMethods[$action])) throw new IllegalArgumentException(sprintf('action %s not found', $action));

      // assemble arguments
      $action_args= array();
      if ($actionMethods[$action]->hasAnnotation('action', 'args')) {
        foreach (explode(',', $actionMethods[$action]->getAnnotation('action', 'args')) as $arg) {
          $arg= trim($arg);
          if (!isset(self::$artefacts[$arg])) throw new IllegalStateException(sprintf('unknown artefact "%s" requested by action "%s"', $arg, $action));
          $action_args[]= call_user_func_array(array(self, self::$artefacts[$arg]), array($params));
        }
      }

      try {
        call_user_func_array(array($proxy, $actionMethods[$action]->getName()), $action_args);
      } catch (XPException $e) {
        Console::$err->write($e->getMessage());
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
    public static function getCursor($params) {
      return new xp·ide·Cursor(
        $params->value('cursor-position', 'cp'),
        $params->value('cursor-line',     'cl'),
        $params->value('cursor-column',   'cc')
      );
    }

    /**
     * get input stream
     *
     * @param util.cmd.ParamString params
     * @return io.streams.InputStream
     */
    public static function getInputStream($params) {
      return new ChannelInputStream('stdin');
    }

    /**
     * get source language
     *
     * @param util.cmd.ParamString params
     * @return xp.ide.lint.language
     */
    public static function getLanguage($params) {
      return XPClass::forName('xp.ide.lint.'.ucFirst(strToLower($params->value('language-name', 'ln'))))->newInstance();
    }

    /**
     * Show usage
     */
    public static function usage() {
      Console::$out->writeLine('** Usage: xpide xp.ide.Runner "proxy" "action" [--encoding] [--cursor-position --cursor-line --cursor-column]');
      Console::$out->writeLine('   - proxy: a classname from the namespace xp.ide.proxy (e.g. "Nedit")');
      Console::$out->writeLine('   - action: XpIde action');
      Console::$out->writeLine('   - encoding (e): input stream encoding (defaults to UTF-8)');
      Console::$out->writeLine(' * Cursor: parameters to assamble the cursor');
      Console::$out->writeLine('   - cursor-position (cp): Cursor char position in the text buffer');
      Console::$out->writeLine('   - cursor-line (cl):     Cursor line');
      Console::$out->writeLine('   - cursor-column (cc):   Cursor char position in the line');
      Console::$out->writeLine(' * Language: parameters to assamble the source language');
      Console::$out->writeLine('   - language-name (ln): language name (e.g "php")');
    }

  }
?>
