<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package="xp.ide.info";

  uses(
    'lang.Enum'
  );

  /**
   * Source tree reprensentation
   *
   * @purpose  IDE
   */
  class xp·ide·info·InfoType extends Enum {
    public static
      $MEMBER;

    static function __static() {
      self::$MEMBER= newinstance(__CLASS__, array(1, 'MEMBER'), '{ static function __static() {}}');
    }
  }

?>
