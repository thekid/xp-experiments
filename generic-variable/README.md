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
```diff
diff -u /home/friebe/devel/xp.public/core/src/main/php/lang/ArrayType.class.php lang/ArrayType.class.php
--- /home/friebe/devel/xp.public/core/src/main/php/lang/ArrayType.class.php 2012-05-13 20:07:16.131695400 +0200
+++ lang/ArrayType.class.php  2012-10-28 13:36:44.058968100 +0100
@@ -62,5 +62,31 @@
       }
       return TRUE;
     }
+
+    /**
+     * Returns whether this type has a constructor
+     *
+     * @return  bool
+     */
+    public function hasConstructor() {
+      return FALSE;
+    }
+
+    /**
+     * Creates a new array instance
+     *
+     * <code>
+     *   $array= Type::forName('int[]')->newInstance(array(1, 2, 3));
+     * </code>
+     *
+     * @param  var[] array
+     * @param  var[]
+     */
+    public function newInstance($array= array()) {
+      if (!$this->isInstance($array)) {
+        throw new IllegalArgumentException('Given input is not a '.$this->name.': '.xp::typeOf($array));
+      }
+      return $array;
+    }
   }
 ?>
diff -u /home/friebe/devel/xp.public/core/src/main/php/lang/MapType.class.php lang/MapType.class.php
--- /home/friebe/devel/xp.public/core/src/main/php/lang/MapType.class.php 2012-05-13 20:07:16.152696600 +0200
+++ lang/MapType.class.php  2012-10-28 13:36:40.346161600 +0100
@@ -62,5 +62,31 @@
       }
       return TRUE;
     }
+
+    /**
+     * Returns whether this type has a constructor
+     *
+     * @return  bool
+     */
+    public function hasConstructor() {
+      return FALSE;
+    }
+
+    /**
+     * Creates a new array instance
+     *
+     * <code>
+     *   $map= Type::forName('[:int]')->newInstance(array('one' => 1, 'two' => 2));
+     * </code>
+     *
+     * @param  [:var] args
+     * @param  [:var]
+     */
+    public function newInstance($map= array()) {
+      if (!$this->isInstance($map)) {
+        throw new IllegalArgumentException('Given input is not a '.$this->name.': '.xp::typeOf($map));
+      }
+      return $map;
+    }
   }
 ?>
diff -u /home/friebe/devel/xp.public/core/src/main/php/lang/Primitive.class.php lang/Primitive.class.php
--- /home/friebe/devel/xp.public/core/src/main/php/lang/Primitive.class.php 2012-05-13 20:07:16.155696800 +0200
+++ lang/Primitive.class.php  2012-10-28 13:38:28.111150900 +0100
@@ -28,6 +28,8 @@
    * @purpose  Type implementation
    */
   class Primitive extends Type {
+    protected $default= NULL;
+
     public static
       $STRING  = NULL,
       $INT     = NULL,
@@ -38,11 +40,22 @@
       $INTEGER = NULL;    // deprecated
     
     static function __static() {
-      self::$STRING= new self('string');
-      self::$INTEGER= self::$INT= new self('int');
-      self::$DOUBLE= new self('double');
-      self::$BOOLEAN= self::$BOOL= new self('bool');
-      self::$ARRAY= new self('array');
+      self::$STRING= new self('string', '');
+      self::$INTEGER= self::$INT= new self('int', 0);
+      self::$DOUBLE= new self('double', 0.0);
+      self::$BOOLEAN= self::$BOOL= new self('bool', FALSE);
+      self::$ARRAY= new self('array', array());
+    }
+
+    /**
+     * Creates a new primitive instance
+     *
+     * @param  string name
+     * @param  var default
+     */
+    public function __construct($name, $default) {
+      parent::__construct($name);
+      $this->default= $default;
     }
     
     /**
@@ -139,5 +152,33 @@
         : $this === Type::forName(gettype($obj))
       ;
     }
+
+    /**
+     * Returns whether this type has a constructor
+     *
+     * @return  bool
+     */
+    public function hasConstructor() {
+      return FALSE;
+    }
+
+    /**
+     * Creates a new array instance
+     *
+     * <code>
+     *   $i= Type::forName('int')->newInstance(1);
+     * </code>
+     *
+     * @param  [:var] var
+     * @param  [:var]
+     */
+    public function newInstance($var= NULL) {
+      if (NULL === $var) {
+        return $this->default;
+      } else if (!$this->isInstance($var)) {
+        throw new IllegalArgumentException('Given input is not a '.$this->name.': '.xp::typeOf($var));
+      }
+      return $var;
+    }
   }
 ?>
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