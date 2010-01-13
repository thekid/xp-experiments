<?php

  uses(
    'ioc.Injector',
    'ioc.Module'
  );

  class IoC extends Object {
    public static function getInjectorFor(ioc·Module $module) {
      return new ioc·Injector($module);
    }
  }
?>