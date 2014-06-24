<?php namespace impl;

use lang\XPClass;

abstract class Events extends \lang\Object {
  public static $impl;

  static function __static() {
    if (extension_loaded('event')) {
      self::$impl= XPClass::forName('impl.event.Events');
    } else if (extension_loaded('libevent')) {
      self::$impl= XPClass::forName('impl.libevent.Events');
    }
  }

  static function factory() {
    if (self::$impl) {
      return self::$impl->newInstance();
    } else {
      throw new \lang\IllegalStateException('No event support');
    }
  }
}