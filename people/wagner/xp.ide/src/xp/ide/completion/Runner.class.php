<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.completion';
  
  uses(
    'lang.XPClass',
    'io.streams.ChannelInputStream',
    'xp.ide.completion.Cursor',
    'util.cmd.ParamString'
  );
  
  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·completion·Runner extends Object {

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    public static function main(array $args) {
      $class= XPClass::forName(array_shift($args));
      $inst= $class->newInstance();

      $params= new ParamString($args);
      $inputStream= new ChannelInputStream('stdin');

      $completeMethod= NULL;
      foreach ($class->getMethods() as $method) {
        if ($method->hasAnnotation('complete')) $completeMethod= $method;
      }

      $inputStreamField= NULL;
      $cursorField= NULL;
      foreach ($class->getFields() as $field) {
        if ($field->hasAnnotation('InputStream')) $inputStreamField= $field;
        if ($field->hasAnnotation('Cursor'))      $cursorField= $field;
      }

      if ($cursorField) $cursorField->set($inst, new xp·ide·completion·Cursor(
        $params->value('position'),
        $params->value('line'),
        $params->value('column')
      ));

      if ($inputStreamField) $inputStreamField->set($inst, $inputStream);

      if (!is_null($completeMethod)) return $completeMethod->invoke($inst);
      return 1;
    }

  }
?>
