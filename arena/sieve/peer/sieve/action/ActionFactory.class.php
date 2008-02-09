<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Action factory
   *
   * @purpose  Factory
   */
  class ActionFactory extends Object {
    protected static $actions= array();

    static function __static() {
      self::$actions['vacation']= XPClass::forName('peer.sieve.action.VacationAction');
      self::$actions['stop']= XPClass::forName('peer.sieve.action.StopAction');
      self::$actions['keep']= XPClass::forName('peer.sieve.action.KeepAction');
      self::$actions['reject']= XPClass::forName('peer.sieve.action.RejectAction');
      self::$actions['fileinto']= XPClass::forName('peer.sieve.action.FileIntoAction');
      self::$actions['stop']= XPClass::forName('peer.sieve.action.StopAction');
      self::$actions['forward']= XPClass::forName('peer.sieve.action.ForwardAction');
      self::$actions['redirect']= XPClass::forName('peer.sieve.action.RedirectAction');
      self::$actions['discard']= XPClass::forName('peer.sieve.action.DiscardAction');
      self::$actions['addflag']= XPClass::forName('peer.sieve.action.AddFlagAction');
      self::$actions['notify']= XPClass::forName('peer.sieve.action.NotifyAction');
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
