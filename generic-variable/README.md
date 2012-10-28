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
If we want to support other types, we would need to resort to `create`. All
of the following should work:

```php
<?php
  create('new Preference<ContentType>', ...);   // Generic Preference<T>
  create('new ContentType', ...);               // ContentType instance
  create('new int[]', ...);                     // int-array
  create('new [:int]', ...);                    // string => int-map
  create('new int', ...);                       // int primitive
?>
```

This way, we can write `$r[]= create("new $T", $value);` in the above example.

(See also http://msdn.microsoft.com/en-us/library/fa0ab757.aspx)


Implementation
--------------
The implementation consists of three parts:

1. The `create()` core functionality is changed to parse input without 
   `<` and `>`, using the complete input after `new ` for the type name.
2. The `lang.Type` hierarchy gets two new methods: `hasConstructor()` 
   and `newInstance()` - *the latter already exists inside `lang.XPClass`*.
3. The generic type creation inside `lang.XPClass` introduces static
   variables with the names of the placeholders into any method annotated 
   with `@generic` and initializes them to the type string (see below).

```diff
diff -u /home/friebe/devel/xp.public/core/src/main/php/lang/XPClass.class.php lang/XPClass.class.php
--- /home/friebe/devel/xp.public/core/src/main/php/lang/XPClass.class.php 2012-10-21 12:59:52.138331500 +0200
+++ lang/XPClass.class.php  2012-10-28 10:55:05.172391000 +0100
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