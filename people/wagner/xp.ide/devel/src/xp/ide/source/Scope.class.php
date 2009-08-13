<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package="xp.ide.source";

  uses(
    'lang.Enum'
  );

  /**
   * Source tree reprensentation
   *
   * @purpose  IDE
   */
  class xp·ide·source·Scope extends Enum {
    public static
      $PRIVATE,
      $PROTECTED,
      $PUBLIC;

    static function __static() {
      self::$PRIVATE=   newinstance(__CLASS__, array(1, 'PRIVATE'), '{ static function __static() {}}');
      self::$PROTECTED= newinstance(__CLASS__, array(1, 'PROTECTED'), '{ static function __static() {}} ');
      self::$PUBLIC=    newinstance(__CLASS__, array(1, 'PUBLIC'), '{ static function __static() {}} ');
    }
  }

?>
