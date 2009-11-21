<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum');

  /**
   * XML event types enumeration
   *
   * @see      xp://xml.streams.XmlStreamReader
   */
  class XmlEventType extends Enum {
    public static 
      $START_ELEMENT,
      $END_ELEMENT,
      $PROCESSING_INSTRUCTION,
      $CHARACTERS,
      $COMMENT,
      $START_DOCUMENT,
      $END_DOCUMENT,
      $DOCTYPE,
      $ENTITY_REF,
      $CDATA;
    
    static function __static() {
      self::$START_ELEMENT= new self(1, 'START_ELEMENT');
      self::$END_ELEMENT= new self(2, 'END_ELEMENT');
      self::$PROCESSING_INSTRUCTION= new self(3, 'PROCESSING_INSTRUCTION');
      self::$CHARACTERS= new self(4, 'CHARACTERS');
      self::$COMMENT= new self(5, 'COMMENT');
      self::$START_DOCUMENT= new self(6, 'START_DOCUMENT');
      self::$END_DOCUMENT= new self(7, 'END_DOCUMENT');
      self::$DOCTYPE= new self(8, 'DOCTYPE');
      self::$ENTITY_REF= new self(9, 'ENTITY_REF');
      self::$CDATA= new self(10, 'CDATA');
    }
    
    /**
     * Returns all enum members
     *
     * @return  lang.Enum[]
     */
    public static function values() {
      return parent::membersOf(__CLASS__);
    }
  }
?>
