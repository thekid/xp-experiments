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
What the above `newinstance` call translates to:

```php
class ArrayList·383ce71a extends ArrayList implements Enumerable { use __Enumerable }
$list= new ArrayList·383ce71a(1, 2, 3);
```