Generators
==========
Introduced in PHP 5.5, generators allow us to get rid of the need to 
fill and return arrays from methods when the purpose is iteration, not
creating the array for the array's sake.

For more details on PHP's implementation, see [the Generators RFC](https://wiki.php.net/rfc/generators).

Basic approach
--------------
The following method returns all methods in a given class with a certain
annotation:

```php
  public function methodsAnnotatedWith(XPClass $self, $annotation) {
    $r= array();
    foreach ($self->getMethods() as $method) {
      if ($method->hasAnnotation($annotation)) $r[]= $method;
    }
    return $r;
  }
```

With generators, this can be simplified by using the `yield` statement:

```php
  public function methodsAnnotatedWith(XPClass $self, $annotation) {
    foreach ($self->getMethods() as $method) {
      if ($method->hasAnnotation($annotation)) yield $method;
    }
  }
```

Any user iterating over the results with `foreach` will have a compatible
interface to use. 

**Note**: If you rely on the return value being an array, though, and use 
`methodsAnnotatedWith(...)[0]`, you will get a fatal error ("Cannot use 
object of type Generator as array").

Experiments
-----------
The first experiment shows the above `methodsAnnotatedWith` method. To 
run it, use the following:

```sh
$ xp Methods net.xp_framework.unittest.core.ObjectTest
```

The second experiment measures performance and memory usage of the array
and the generator implementation from above. It can be used as follows:

```sh
$ xp Performance ARRAY net.xp_framework.unittest.core.ObjectTest
$ xp Performance GENERATOR net.xp_framework.unittest.core.ObjectTest
```

We can see that both implementations perform comparably in most cases.
You can find a small micro benchmark at https://gist.github.com/2975796

The third experiment shows how processing multiple input sources at
once can be done: Each input is represented by a generator and pulled
together with another generator, one item at a time per iterator.

```sh
$ xp MultipleInputs
```

Real-life code simplifications
------------------------------
This shows how we could simplify the XP Framework's sourcecode in the 
future by using generators inside `IteratorAggregate` implementations:

```diff
--- ~/devel/xp.public/core/src/main/php/util/collections/Vector.class.php    2012-04-15 19:11:57.953682200 +0200
+++ overlay/util/collections/Vector.class.php   2012-12-21 10:17:30.152100800 +0100
@@ -17,25 +17,10 @@
    */
   #[@generic(self= 'T', implements= array('T'))]
   class Vector extends Object implements IList {
-    protected static
-      $iterate   = NULL;
-
     protected
       $elements  = array(),
       $size      = 0;

-    static function __static() {
-      self::$iterate= newinstance('Iterator', array(), '{
-        private $i= 0, $v;
-        public function on($v) { $self= new self(); $self->v= $v; return $self; }
-        public function current() { return $this->v[$this->i]; }
-        public function key() { return $this->i; }
-        public function next() { $this->i++; }
-        public function rewind() { $this->i= 0; }
-        public function valid() { return $this->i < sizeof($this->v); }
-      }');
-    }
-
     /**
      * Constructor
      *
@@ -54,7 +39,9 @@
      * @return  php.Iterator
      */
     public function getIterator() {
-      return self::$iterate->on($this->elements);
+      foreach ($this->elements as $element) {
+        yield $element;
+      }
     }

     /**
```

To verify this works, run the util.collections test suite:

```sh
$ unittest net.xp_framework.unittest.util.collections.**
```