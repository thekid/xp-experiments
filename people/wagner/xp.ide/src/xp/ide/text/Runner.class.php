<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.text';
  
  uses(
    'lang.XPClass',
    'io.streams.ChannelInputStream',
    'xp.ide.Cursor',
    'util.cmd.ParamString'
  );
  
  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·text·Runner extends Object {

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    public static function main(array $args) {
      $class= XPClass::forName('xp.ide.text.'.array_shift($args));
      $inst= $class->newInstance();

      $params= new ParamString($args);
      $inputStream= new ChannelInputStream('stdin');

      $actionMethods= array();
      foreach ($class->getMethods() as $method) {
        if ($method->hasAnnotation('action')) $actionMethods[$method->getAnnotation('action', 'name')]= $method;
      }

      $inputStreamField= NULL;
      $cursorField= NULL;
      foreach ($class->getFields() as $field) {
        if ($field->hasAnnotation('InputStream')) $inputStreamField= $field;
        if ($field->hasAnnotation('Cursor'))      $cursorField= $field;
      }

      if ($cursorField) $cursorField->set($inst, new xp·ide·Cursor(
        $params->value('position'),
        $params->value('line'),
        $params->value('column')
      ));

      if ($inputStreamField) $inputStreamField->set($inst, $inputStream);

      if ($params->exists('action')) return $actionMethods[$params->value('action')]->invoke($inst);
      return 1;
    }

  }
?>
