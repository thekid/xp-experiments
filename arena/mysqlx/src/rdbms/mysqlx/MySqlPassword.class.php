<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum');

  /**
   * (Insert class' description here)
   *
   * @see   php://sha1
   * @see   http://forge.mysql.com/wiki/MySQL_Internals_ClientServer_Protocol
   */
  abstract class MySqlPassword extends Enum {
    public static 
      $PROTOCOL_41= NULL;
    
    static function __static() {
      self::$PROTOCOL_41= newinstance(__CLASS__, array(0, '$PROTOCOL_41'), '{
        static function __static() { }
        public function scramble($password, $message) {
          if ("" === $password || NULL === $password) return "";

          $stage1= sha1($password, TRUE);
          return sha1($message.sha1($stage1, TRUE), TRUE) ^ $stage1;
        }
      }');
    }
    
    
    /**
     * Returns all enum members
     *
     * @return  lang.Enum[]
     */
    public static function values() {
      return parent::membersOf(__CLASS__);
    }
    
    /**
     * Scrambles a given password
     *
     * @param   string password
     * @param   string message
     * @return  string
     */
    public abstract function scramble($password, $message);
  }
?>
