Generic type variables
======================
This experiment tries to verify introducing type variables into generic 
methods can work. These type variables access the runtime type arguments 
of a generic type.

General idea
------------
```php
<?php
  #[@generic(return= 'T[]')]
  public function all() {
    $r= array();
    foreach ($this->list as $value) {
      $r[]= new $T($value);
    }
    return $r;
  }
?>
```

This of course requires `$T` to represent something instantiable via `new`.

Implementation
--------------
```diff
--- /home/friebe/devel/xp.public/core/src/main/php/lang/XPClass.class.php       2012-10-21 12:59:52.138331500 +0200
+++ lang/XPClass.class.php      2012-10-28 10:55:05.172391000 +0100
@@ -1096,7 +1096,10 @@
               array_shift($state);
               array_unshift($state, 4);
               $src.= '{';
-
+              foreach ($placeholders as $placeholder => $type) {
+                $src.= 'static $'.$placeholder.'= "'.$type.'";';
+              }
+
               if (isset($annotations['generic']['return'])) {
                 $meta[1][$m][DETAIL_RETURNS]= strtr($annotations['generic']['return'], $placeholders);
               }
```