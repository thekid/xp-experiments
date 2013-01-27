Traits instance creation
========================
This experiment shows a way to instantiate anonymous classes together with a trait. This can create a kind of local extensibility with the same "feeling" as if extension methods existed.

Given the following trait:

```php
trait Enumerable {
  public function map($block) {
    // ...
  }
}
```

...this is already possible today, using the following:

```php
$list= newinstance('lang.types.ArrayList', array(1, 2, 3), '{ use Enumerable; }');
$list->map(...);
```

In this experiment, we change the `newinstance` parameter to accept a list of traits together with the class name, changing the above example to the following:

```php
$list= newinstance('lang.types.ArrayList with experiment.Enumerable', array(1, 2, 3)));
$list->map(...);
```

Type safety
-----------
Because we'd also be check via `instanceof` on a trait type name, we go a step farther and create a companion interface for each trait. 

```php
interface Enumerable {} trait __Enumerable {
  public function map($block) {
    // ...
  }
}
```

This way, the instance really *is an* Enumerable.

Inner workings
--------------
What the above `newinstance()` call translates to:

```php
class ArrayList·d383ce71a extends ArrayList implements Enumerable { use __Enumerable; }
$list= new ArrayList·d383ce71a(1, 2, 3);
```

Further ideas
-------------
In XP Language, this could be written as:

```groovy
$list= new lang.types.ArrayList(1, 2, 3) with experiment.Enumerable;
$list.map(...);
```

This raises the idea of decorating any expression with `with`, e.g.:

```groovy
foreach ($method in (self::class.getMethods() with Annotations).annotatedWith('test')) {
  Console::writeLine('Test method ', $method)
}
```groovy

The `Annotations` trait would be something like:

```groovy
trait Annotations<T> {
  public T[] annotatedWith(string? $annotation) {
    $r= new T[] {};
    foreach ($element in $this) {
      if ($element.hasAnnotation($annotation)) $r[]= $element;
    }
    return $r;
  }
}
```

See also
--------
* http://docs.scala-lang.org/tutorials/tour/mixin-class-composition.html
* http://docs.scala-lang.org/tutorials/tour/traits.html