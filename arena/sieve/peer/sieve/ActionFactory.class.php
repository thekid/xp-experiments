<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class ActionFactory extends Object {
    protected static $actions= array();

    static function __static() {
      self::$actions['vacation']= XPClass::forName('peer.sieve.VacationAction');
      self::$actions['stop']= XPClass::forName('peer.sieve.StopAction');
      self::$actions['keep']= XPClass::forName('peer.sieve.KeepAction');
      self::$actions['reject']= XPClass::forName('peer.sieve.RejectAction');
      self::$actions['fileinto']= XPClass::forName('peer.sieve.FileIntoAction');
      self::$actions['stop']= XPClass::forName('peer.sieve.StopAction');
      self::$actions['forward']= XPClass::forName('peer.sieve.ForwardAction');
      self::$actions['redirect']= XPClass::forName('peer.sieve.RedirectAction');
      self::$actions['discard']= XPClass::forName('peer.sieve.DiscardAction');
      self::$actions['addflag']= XPClass::forName('peer.sieve.AddFlagAction');
      self::$actions['notify']= XPClass::forName('peer.sieve.NotifyAction');
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @return  peer.sieve.Action
     * @throws  lang.IllegalArgumentException in case an unknown action is encountered
     */
    public static function newAction($name) {
      if (!isset(self::$actions[$name])) {
        throw new IllegalArgumentException('Unsupported action "'.$name.'"');
      }
      return self::$actions[$name]->newInstance();
    }
  }
?>
